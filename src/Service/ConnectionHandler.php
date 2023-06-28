<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Service;

use App\AppBundle\Exception\InvalidXMLException;
use App\AppBundle\Exception\TransformationException;
use App\AppBundle\Model\RestResponse;
use App\InvoiceBundle\Serializer\InvoiceSerializer;
use Flexibill\NavBundle\Enum\BasicResultResponseFunctionCodeEnum;
use Flexibill\NavBundle\Enum\InvoiceOperationEnum;
use Flexibill\NavBundle\Exception\ConnectionException;
use Flexibill\NavBundle\Exception\InvalidRequestException;
use Flexibill\NavBundle\Exception\ReachedInvoiceLimitException;
use Flexibill\NavBundle\Factory\HeaderFactory;
use Flexibill\NavBundle\Factory\QueryInvoiceDataRequestFactory;
use Flexibill\NavBundle\Factory\QueryInvoiceDigestRequestFactory;
use Flexibill\NavBundle\Factory\QueryInvoiceStatusRequestFactory;
use Flexibill\NavBundle\Factory\QueryTaxPayerRequestFactory;
use Flexibill\NavBundle\Factory\SoftwareFactory;
use Flexibill\NavBundle\Model\InvoiceQueryDigestParams;
use Flexibill\NavBundle\Model\ManageAnnulmentRequest;
use Flexibill\NavBundle\Model\ManageAnnulmentResponse;
use Flexibill\NavBundle\Model\ManageInvoiceRequest;
use Flexibill\NavBundle\Model\ManageInvoiceResponse;
use Flexibill\NavBundle\Model\QueryInvoiceDataRequest;
use Flexibill\NavBundle\Model\QueryInvoiceDataResponse;
use Flexibill\NavBundle\Model\QueryInvoiceDigestRequest;
use Flexibill\NavBundle\Model\QueryInvoiceDigestResponse;
use Flexibill\NavBundle\Model\QueryInvoiceStatusResponse;
use Flexibill\NavBundle\Model\QueryTaxpayerRequest;
use Flexibill\NavBundle\Model\QueryTaxpayerResponse;
use Flexibill\NavBundle\Model\QueryTransactionStatusRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\TokenExchange;
use Flexibill\NavBundle\Model\User;
use Flexibill\NavBundle\Utils\RequestIdGenerator;
use Flexibill\NavBundle\Utils\RequestSignatureGenerator;
use Exception;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Manager
 * @package Flexibill\NavBundle\Service
 */
class ConnectionHandler
{
    /**
     * @var ConnectorInterface
     */
    private $connector;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $softwareParams;

    /**
     * @var Software
     */
    private $software;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ManageRequestXMLMaker
     */
    private $manageRequestXMLMaker;

    /**
     * ConnectionHandler constructor.
     *
     * @param SerializerInterface $serializer
     * @param ConnectorInterface $connector
     * @param LoggerInterface $logger
     * @param ManageRequestXMLMaker $manageRequestXMLMaker
     * @param ValidatorInterface $validator
     * @param array $softwareParams
     */
    public function __construct(
        SerializerInterface $serializer,
        ConnectorInterface $connector,
        LoggerInterface $logger,
        ManageRequestXMLMaker $manageRequestXMLMaker,
        ValidatorInterface $validator,
        array $softwareParams
    )
    {
        $this->connector = $connector;
        $this->serializer = $serializer;
        $this->softwareParams = $softwareParams;
        $this->logger = $logger;
        $this->manageRequestXMLMaker = $manageRequestXMLMaker;
        $this->validator = $validator;
        $this->software = $this->initSoftware();
    }

    /**
     * @param User $user
     * @param InvoiceQueryDigestParams $invoiceQueryParams
     * @param string $direction
     * @param int $page
     *
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     */
    public function queryInvoiceDigestRequest(
        User $user,
        InvoiceQueryDigestParams $invoiceQueryParams,
        string $direction,
        int $page
    ): QueryInvoiceDigestResponse
    {
        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate($requestId, $user->getXmlSignKey());
        $user->setRequestSignature($requestSignature);

        $request = QueryInvoiceDigestRequestFactory::create(
            $user,
            $this->software,
            $invoiceQueryParams,
            $direction,
            $requestId,
            $page
        );

        $serializedRequest = $this->serializer->serialize($request, InvoiceSerializer::TYPE_XML);

        $response = $this->connector->connect(QueryInvoiceDigestRequest::PATH, $serializedRequest);

        return $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            QueryInvoiceDigestResponse::class,
            InvoiceSerializer::TYPE_XML
        );
    }

    /**
     * @param User $user
     * @param string $invoiceId
     * @param string $invoiceDirection
     * @param string $supplierTaxNumber
     *
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     */
    public function queryInvoiceDataRequest(
        User $user,
        string $invoiceId,
        string $invoiceDirection,
        string $supplierTaxNumber
    )
    {
        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate($requestId, $user->getXmlSignKey());
        $user->setRequestSignature($requestSignature);

        $request = QueryInvoiceDataRequestFactory::create(
            $user,
            $this->software,
            $requestId,
            $invoiceId,
            $invoiceDirection,
            $supplierTaxNumber
        );

        $serializedRequest = $this->serializer->serialize($request, InvoiceSerializer::TYPE_XML);

        $response = $this->connector->connect(QueryInvoiceDataRequest::PATH, $serializedRequest);

//        $this->logger->debug('NAV RESPONSE XML:' . SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()));

        return $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            QueryInvoiceDataResponse::class,
            InvoiceSerializer::TYPE_XML
        );
    }

    /**
     * @param User $user
     * @param string $transactionId
     *
     * @return QueryInvoiceStatusResponse
     * @throws InvalidRequestException
     * @throws Exception
     */
    public function queryInvoiceStatusRequest(User $user, string $transactionId)
    {
        //new request to manage invoice
        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate($requestId, $user->getXmlSignKey());
        $user->setRequestSignature($requestSignature);

        $request = QueryInvoiceStatusRequestFactory::create($user, $this->software, $requestId, $transactionId, false);
        //convert data to xml and send to NAV
        $serializedRequest = $this->serializer->serialize(
            $request,
            InvoiceSerializer::TYPE_XML,
            InvoiceSerializer::getSpecificSerializationContext()
        );
        $this->logger->debug($serializedRequest);

        /** @var RestResponse $response */
        $response = $this->connector->connect(QueryTransactionStatusRequest::PATH, $serializedRequest);

        if (!$response->isSuccessful()) {
            throw new ConnectionException(
                "Something went wrong in API connection. Response Status Code: " . $response->getStatusCode()
            );
        }

        /** @var QueryInvoiceStatusResponse $deserializedResponse */
        $deserializedResponse = $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            QueryInvoiceStatusResponse::class,
            InvoiceSerializer::TYPE_XML
        );

        $this->logger->debug("Result Code: " . $deserializedResponse->getResult()->getFuncCode());

        if ($deserializedResponse->getResult()->getFuncCode() !== BasicResultResponseFunctionCodeEnum::OK) {
            $this->logger->error("Error  Code: " . $deserializedResponse->getResult()->getErrorCode());
            $this->logger->error("Message: " . $deserializedResponse->getResult()->getMessage());
            $this->logger->error("Invalid request  [ {$deserializedResponse->getResult()->getErrorCode()} ]");

            throw new InvalidRequestException($deserializedResponse->getResult()->getErrorCode());
        }

        return $deserializedResponse;
    }

    /**
     * @param User $user
     * @param string $taxNumber
     *
     * @return QueryTaxpayerResponse
     *
     * @throws Exception
     */
    public function queryTaxPayerRequest(User $user, string $taxNumber): QueryTaxpayerResponse
    {
        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate($requestId, $user->getXmlSignKey());

        $user->setRequestSignature($requestSignature);

        $request = QueryTaxPayerRequestFactory::create($user, $this->software, $requestId, substr($taxNumber, 0, 8));

        $serializedRequest = $this->serializer->serialize($request, InvoiceSerializer::TYPE_XML);

        $response = $this->connector->connect(QueryTaxpayerRequest::PATH, $serializedRequest);

        return $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            QueryTaxpayerResponse::class,
            InvoiceSerializer::TYPE_XML
        );
    }

    /**
     * @param User $user
     * @param TokenExchange $tokenExchange
     * @param InvoiceCollection $invoices
     *
     * @return ManageAnnulmentResponse
     * @throws ConnectionException
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws \App\AppBundle\Exception\TransformationInvalidTypeException
     */
    public function technicalAnnulmentRequest(User $user, TokenExchange $tokenExchange, InvoiceCollection $invoices)
    {
        $response = $this->connector->connect(
            ManageAnnulmentRequest::PATH,
            $this->manageRequestXMLMaker->makeAnnulment($user, $tokenExchange, $this->software, $invoices)
        );

        if (!$response->isSuccessful()) {
            throw new ConnectionException(
                "Something went wrong in API connection. Response Status Code: " . $response->getStatusCode()
            );
        }

        /** @var ManageAnnulmentResponse $manageAnnulmentResponse */
        return $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            ManageAnnulmentResponse::class,
            InvoiceSerializer::TYPE_XML
        );
    }

    /**
     * @param User $user
     * @param TokenExchange $tokenExchange
     * @param string $operation
     * @param array $invoices
     * @param bool $compressed
     *
     * @return ManageInvoiceResponse
     * @throws ConnectionException
     * @throws InvalidRequestException
     * @throws ReachedInvoiceLimitException
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws Exception
     * @throws ReflectionException
     */
    public function manageInvoiceRequest(
        User $user,
        TokenExchange $tokenExchange,
        string $operation,
        InvoiceCollection $invoices,
        bool $compressed = false
    )
    {
        //validation
        $this->manageRequestValidate($user, $operation);

        $this->logger->debug("Token: " . $tokenExchange->getEncodedExchangeToken());
        $this->logger->debug("Operation: " . $operation);
        $this->logger->debug("Number of invoices to be send: " . count($invoices->getInvoices()));

        //set a limit because of the load
        if (count($invoices->getInvoices()) >= ManageInvoiceRequest::TO_SEND_INVOICE_LIMIT) {
            $this->logger->warning("Invoice count is reached the limit -- exception");
            throw new ReachedInvoiceLimitException();
        }

        $serializedRequest = $this->manageRequestXMLMaker->make(
            $invoices,
            $user,
            $this->software,
            $tokenExchange,
            $operation,
            $compressed
        );

        $this->logger->debug($serializedRequest);

        /** @var RestResponse $response */
        $response = $this->connector->connect(
            ManageInvoiceRequest::PATH,
            $serializedRequest
        );

        if (!$response->isSuccessful()) {
            $this->logger->debug('Manage invoice request - SomethingWentWrongInApiConnection:'. $response->getBodyAsString());
            throw new ConnectionException(
                "Something went wrong in API connection. Response Status Code: " . $response->getStatusCode()
            );
        }

        /** @var ManageInvoiceResponse $manageInvoiceResponse */
        $manageInvoiceResponse = $this->serializer->deserialize(
            SanitizeFromXmlNamespace::sanitize($response->getBodyAsString()),
            ManageInvoiceResponse::class,
            InvoiceSerializer::TYPE_XML
        );

        $this->logger->debug("Result Code: " . $manageInvoiceResponse->getResult()->getFuncCode());

        if ($manageInvoiceResponse->getResult()->getFuncCode() !== BasicResultResponseFunctionCodeEnum::OK) {
            $this->logger->error("Error  Code: " . $manageInvoiceResponse->getResult()->getErrorCode());
            $this->logger->error("Message: " . $manageInvoiceResponse->getResult()->getMessage());
            $this->logger->error("Invalid request  [ {$manageInvoiceResponse->getResult()->getErrorCode()} ]");

            throw new InvalidRequestException($manageInvoiceResponse->getResult()->getErrorCode());
        }

        return $manageInvoiceResponse;
    }

    /**
     * @param User $user
     * @param string $operation
     *
     * @throws InvalidRequestException
     * @throws ReflectionException
     */
    public function manageRequestValidate(User $user, string $operation)
    {
        //Validation
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new InvalidRequestException("UserData is not valid. Errors:" . (string)$errors);
        }

        if (!in_array($operation, InvoiceOperationEnum::getChoices())) {
            throw new InvalidRequestException("Not valid operation. Available operations in InvoiceOperationEnum");
        }
    }

    /**
     * @param User $user
     * @param $requestId
     * @param string|null $exchangeToken
     *
     * @return ManageInvoiceRequest
     */
    public function requestInit(User $user, $requestId, string $exchangeToken = null)
    {
        $request = new ManageInvoiceRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($this->software);
        $request->setExchangeToken($exchangeToken);

        return $request;
    }

    /**
     * @return Software
     */
    public function initSoftware()
    {
        $developer = $this->getProperty('developer', $this->softwareParams);

        return SoftwareFactory::create(
            $this->getProperty('id', $this->softwareParams),
            $this->getProperty('name', $this->softwareParams),
            $this->getProperty('operation', $this->softwareParams),
            $this->getProperty('version', $this->softwareParams),
            $this->getProperty('name', $developer),
            $this->getProperty('contact', $developer),
            $this->getProperty('country_code', $developer),
            $this->getProperty('tax_number', $developer)
        );
    }

    /**
     * @param $param
     * @param $array
     *
     * @return mixed|null
     */
    private function getProperty($param, $array)
    {
        if (!is_array($array)) {
            return null;
        }

        return $array[$param] ?? null;
    }
}
