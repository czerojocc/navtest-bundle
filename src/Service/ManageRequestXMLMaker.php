<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

use App\AppBundle\Exception\InvalidXMLException;
use App\AppBundle\Exception\TransformationException;
use App\InvoiceBundle\Serializer\InvoiceSerializer;
use Flexibill\NavBundle\Factory\ManageAnnulmentRequestFactory;
use Flexibill\NavBundle\Factory\ManageInvoiceRequestFactory;
use Flexibill\NavBundle\Model\AnnulmentOperation;
use Flexibill\NavBundle\Model\InvoiceOperation;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\TokenExchange;
use Flexibill\NavBundle\Model\User;
use Flexibill\NavBundle\Transformer\NavXMLTransformer;
use Flexibill\NavBundle\Utils\RequestIdGenerator;
use Flexibill\NavBundle\Utils\RequestSignatureGenerator;
use Flexibill\NavBundle\Utils\SHA512HashMaker;
use Exception;
use JMS\Serializer\SerializerInterface;

/**
 * Class ManageRequestXMLMaker
 * @package Flexibill\NavBundle\Service
 */
class ManageRequestXMLMaker
{
    /**
     * @var OperationManager
     */
    private $operationManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ManageRequestXMLMaker constructor.
     *
     * @param OperationManager $operationManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        OperationManager $operationManager,
        SerializerInterface $serializer
    )
    {
        $this->operationManager = $operationManager;
        $this->serializer = $serializer;
    }

    /**
     * @param User $user
     * @param TokenExchange $tokenExchange
     * @param Software $software
     * @param InvoiceCollection $invoices
     *
     * @return string
     *
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws \App\AppBundle\Exception\TransformationInvalidTypeException
     */
    public function makeAnnulment(User $user, TokenExchange $tokenExchange, Software $software, InvoiceCollection $invoices)
    {
        $encodedInvoices = $invoices->getEncodedInvoices();

        $hash = [];
        $annulmentOperations = [];

        foreach ($encodedInvoices as $key => $invoice) {
            $hash[] = $this->generateHash('ANNUL', $invoice);

            $annulmentOperation = new AnnulmentOperation();
            $annulmentOperation->setIndex(++$key);
            $annulmentOperation->setInvoiceAnnulment($invoice);

            $annulmentOperations[] = $annulmentOperation;
        }

        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate(
            $requestId,
            $user->getXmlSignKey(),
            count($hash) > 0 ? implode("", $hash) : null
        );

        $user->setRequestSignature($requestSignature);

        $decodedExchangeToken = $tokenExchange->getDecodedExchangeToken($user->getExchangeKey());

        $request = ManageAnnulmentRequestFactory::create(
            $user,
            $software,
            $decodedExchangeToken,
            $requestId,
            $annulmentOperations
        );

        return $this->serializer->serialize($request, InvoiceSerializer::TYPE_XML);
    }

    /**
     * @param InvoiceCollection $invoices
     * @param User $user
     * @param Software $software
     * @param TokenExchange $tokenExchange
     * @param string $operation
     * @param bool $compressed
     *
     * @return mixed
     *
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws \App\AppBundle\Exception\TransformationInvalidTypeException
     */
    public function make(
        InvoiceCollection $invoices,
        User $user,
        Software $software,
        TokenExchange $tokenExchange,
        string $operation,
        bool $compressed = false
    )
    {
        $encodedInvoices = $invoices->getEncodedInvoices();

        //prepare the operation list from the data
        $operationList = $this->operationManager->init(
            $operation,
            $encodedInvoices,
            $compressed
        );

        // Calculate Invoice hash part
        $hash = [];
        $operationList->getInvoiceOperations()->map(
            function (InvoiceOperation $invoiceOperation) use (&$hash) {
                $hash[] = $this->generateHash(
                    $invoiceOperation->getOperation(),
                    $invoiceOperation->getInvoice()
                );
            }
        );

        //new request to manage invoice
        $requestId = RequestIdGenerator::generate();
        $requestSignature = RequestSignatureGenerator::generate(
            $requestId,
            $user->getXmlSignKey(),
            count($hash) > 0 ? implode("", $hash) : null
        );

        $user->setRequestSignature($requestSignature);

        $decodedExchangeToken = $tokenExchange->getDecodedExchangeToken($user->getExchangeKey());

        //initialize a manage invoice request from the model
        $request = ManageInvoiceRequestFactory::create(
            $user,
            $software,
            $operationList,
            $decodedExchangeToken,
            $requestId
        );

        //convert data to xml and send to NAV
        return $this->serializer->serialize(
            $request,
            InvoiceSerializer::TYPE_XML,
            InvoiceSerializer::getSpecificSerializationContext()
        );
    }

    /**
     * @param string $operation
     * @param string $invoice
     * @return string
     */
    protected function generateHash(string $operation, string $invoice): string
    {
        return SHA512HashMaker::hash($operation . $invoice, SHA512HashMaker::SHA3_512);
    }
}
