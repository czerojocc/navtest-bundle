<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Service;

use App\AppBundle\Model\RestResponse;
use App\InvoiceBundle\Serializer\InvoiceSerializer;
use Flexibill\NavBundle\Exception\ConnectionException;
use Flexibill\NavBundle\Exception\InvalidRequestException;
use Flexibill\NavBundle\Exception\InvalidTokenExchangeRequestException;
use Flexibill\NavBundle\Factory\HeaderFactory;
use Flexibill\NavBundle\Factory\TokenExchangeRequestFactory;
use Flexibill\NavBundle\Model\GeneralErrorResponse;
use Flexibill\NavBundle\Model\HeaderInterface;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\TokenExchange;
use Flexibill\NavBundle\Model\TokenExchangeRequest;
use Flexibill\NavBundle\Model\TokenExchangeResponse;
use Flexibill\NavBundle\Model\User;
use Flexibill\NavBundle\Utils\RequestIdGenerator;
use Flexibill\NavBundle\Utils\RequestSignatureGenerator;
use DateTime;
use Exception;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TokenExchangeManager
 * @package Flexibill\NavBundle\Service
 */
class TokenExchangeManager implements TokenExchangeManagerInterface
{
    /**
     * Token expiry in sec
     */
    const EXPIRY = 60;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SerializationContext
     */
    private $serializer;

    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * TokenExchangeManager constructor.
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     * @param Connector $connector
     * @param ValidatorInterface $validator
     */
    public function __construct(
        LoggerInterface $logger,
        SerializerInterface $serializer,
        Connector $connector,
        ValidatorInterface $validator
    )
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->connector = $connector;
        $this->validator = $validator;
    }

    /**
     * @param User $user
     * @param Software $software
     * @return TokenExchange
     * @throws InvalidRequestException
     * @throws InvalidTokenExchangeRequestException
     * @throws \Flexibill\NavBundle\Exception\NotEnabledModuleException
     * @throws Exception
     */
    public function getToken(User $user, Software $software) : TokenExchange
    {
        $requestId = RequestIdGenerator::generate();
        $header = HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON);
        $requestSignature = RequestSignatureGenerator::generate($requestId, $user->getXmlSignKey());
        $user->setRequestSignature($requestSignature);

        return $this->getNewExchangeToken($user, $header, $software);
    }

    /**
     * @param User $user
     * @param HeaderInterface $header
     * @param Software $software
     * @return TokenExchange
     * @throws ConnectionException
     * @throws InvalidRequestException
     * @throws InvalidTokenExchangeRequestException
     * @throws \Flexibill\NavBundle\Exception\NotEnabledModuleException
     */
    private function getNewExchangeToken(User $user, HeaderInterface $header, Software $software)
    {
        $this->logger->debug('New exchange token');

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new InvalidRequestException("UserData is not valid. Errors:" . (string)$errors);
        }

        /** @var TokenExchangeResponse $tokenExchangeResponse */
        $tokenExchangeResponse = $this->initTokenExchangeRequestAndSendToNAV($user, $header, $software);
        $encodedExchangeToken = $tokenExchangeResponse->getEncodedExchangeToken();
        $validityFrom = $tokenExchangeResponse->getTokenValidityFrom();
        $validityTo = $tokenExchangeResponse->getTokenValidityTo();

        $tokenExchange = new TokenExchange();
        $tokenExchange
            ->setEncodedExchangeToken($encodedExchangeToken)
            ->setTokenValidityFrom($validityFrom)
            ->setTokenValidityTo($validityTo);

        return $tokenExchange;
    }

    /**
     * @param User $user
     * @param HeaderInterface $header
     * @param Software $software
     * @return TokenExchangeResponse
     * @throws ConnectionException
     * @throws InvalidTokenExchangeRequestException
     * @throws \Flexibill\NavBundle\Exception\NotEnabledModuleException
     */
    private function initTokenExchangeRequestAndSendToNAV(User $user, HeaderInterface $header, Software $software)
    {
        //create token exchange request by model
        $tokenExchangeRequest = TokenExchangeRequestFactory::create($header, $user, $software);

        //tokenExchangeRequest convert to xml
        $serializedTokenExchangeRequest = $this->serializer->serialize($tokenExchangeRequest, InvoiceSerializer::TYPE_XML);

        //custom log to nav_connection.log
        $this->logger->debug("Start of token exchange request by params");
        $this->logger->debug($serializedTokenExchangeRequest);
        $this->logger->debug('Sending xml to NAV API...');

        /** @var RestResponse $response */
        $response = $this->connector->connect(TokenExchangeRequest::PATH, $serializedTokenExchangeRequest);

        //check the status code
        $this->logger->debug("Response status code:" . $response->getStatusCode());

        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 401 || $response->getStatusCode() == 500) {
            /** @var GeneralErrorResponse $generalErrorResponse */
            $generalErrorResponse = $this->serializer->deserialize(
                SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
                GeneralErrorResponse::class,
                InvoiceSerializer::TYPE_XML
            );

            $this->logger->error("Invalid request  [ {$response->getBody()} ]");
            $this->logger->error("Error  [ {$generalErrorResponse->getResult()->getErrorCode()}]");

            throw new InvalidTokenExchangeRequestException($generalErrorResponse->getResult()->getMessage());
        }

        if (!$response->isSuccessful()) {
            throw new ConnectionException("Something went wrong in API connection. Response Status Code: " . $response->getStatusCode());
        }

        /** @var TokenExchangeResponse $tokenExchangeResponse */
        $tokenExchangeResponse = $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            TokenExchangeResponse::class,
            InvoiceSerializer::TYPE_XML
        );

        $this->logger->debug('Successfully get token: ' . $tokenExchangeResponse->getEncodedExchangeToken());

        return $tokenExchangeResponse;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getExpiryDateTime()
    {
        $dateTime = new DateTime('now');
        $dateTime->modify("+" . self::EXPIRY . " seconds");

        return $dateTime;
    }

}
