<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Transformer;

use App\AppBundle\Exception\InvalidXMLException;
use App\AppBundle\Exception\TransformationException;
use App\AppBundle\Service\CountryChecker;
use App\AppBundle\Service\FileManager;
use App\AppBundle\Service\XSLTTransformer;
use App\CompanyBundle\Enum\CompanyLegalEnum;
use App\InvoiceBundle\Entity\Address;
use App\InvoiceBundle\Entity\InvoiceInterface;
use App\InvoiceBundle\Model\Invoice;
use App\InvoiceBundle\Serializer\InvoiceSerializer;
use Flexibill\NavBundle\Validator\PostalCodeValidator;
use DateTime;
use DateTimeZone;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class NavXMLTransformer extends XSLTTransformer implements NavTransformerInterface
{
    const TYPE_DATA = 'data';
    const TYPE_ANNULMENT = 'annulment';

    protected $configPath = '@NavBundle/Resources/config';

    protected $serializer;

    public function __construct(
        KernelInterface     $kernel,
        LoggerInterface     $logger,
        FileManager         $fileManager,
        SerializerInterface $serializer
    )
    {
        parent::__construct($kernel, $logger, $fileManager);

        $this->serializer = $serializer;
    }

    /**
     * @param SerializerInterface $serializer
     *
     * @required
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Invoice|InvoiceInterface $invoice
     *
     * @param bool $validate
     *
     * @return string
     *
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws \App\AppBundle\Exception\TransformationInvalidTypeException
     */
    public function transform(object $invoice, bool $validate = true)
    {
        $this->preTransform($invoice);

        $parameters = $this->getParameters($invoice);

        $document = $this->serializeInvoice($invoice);

        $transformed = $this->xsltTransformation($document, $parameters);

        if ($validate) {
            $this->validate($transformed);
        }

        return $transformed;
    }

    private function preTransform(InvoiceInterface $invoice)
    {
        $customerParty = $invoice->getAccountingCustomerParty();
        $supplierParty = $invoice->getAccountingSupplierParty();

        if ($customerParty && $customerParty->getPostalAddress()) {
            /** @var Address $customerPartyPostalAddress */
            $customerPartyPostalAddress = $customerParty->getPostalAddress();

            $customerPartyPostalAddress->setPostalZone(
                $this->transformPostalCode($customerPartyPostalAddress->getPostalZone())
            );
        }

        if ($supplierParty && $supplierParty->getPostalAddress()) {
            /** @var Address $supplierPartyPostalAddress */
            $supplierPartyPostalAddress = $supplierParty->getPostalAddress();

            $supplierPartyPostalAddress->setPostalZone(
                $this->transformPostalCode($supplierPartyPostalAddress->getPostalZone())
            );
        }
    }

    /**
     * @param InvoiceInterface $invoice
     *
     * @return string
     */
    private function serializeInvoice(InvoiceInterface $invoice)
    {
        return $this->serializer->serialize(
            $invoice,
            InvoiceSerializer::TYPE_XML,
            InvoiceSerializer::getSpecificSerializationContext()
        );
    }

    /**
     * @param Invoice|InvoiceInterface $invoice
     *
     * @return array
     */
    private function getParameters($invoice): array
    {
        $cashAccounting = $invoice->isCashAccounting();
        $modifyWithoutMaster = $invoice->isModifyWithoutMaster();
        $isKata = $invoice->getAccountingSupplierParty()->isKata();
        $isTechnicalAnnulment = $invoice->getInvoiceAnnulmentType() ? true : false;
        $isSelfBilling = $invoice->isSelfBilling() ? true : false;

        $parameters = [];

        $parameters[] = [
            'name' => 'param_ACCSET_PFA',
            'value' => $cashAccounting ? "true" : "false"
        ];

        $parameters[] = [
            'name' => 'param_ACCSET_AAM',
            'value' => $isKata ? "true" : "false"
        ];

        $parameters[] = [
            'name' => 'param_TECHNICAL_ANNULMENT',
            'value' => $isTechnicalAnnulment ? "true" : "false"
        ];

        $parameters[] = [
            'name' => 'param_ACCSET_SELF_BILLING',
            'value' => $isSelfBilling ? "true" : "false"
        ];

        $createdAt = $invoice->getCreatedAt() ?? new DateTime();
        $createdAt->setTimezone(new DateTimeZone('UTC'));
        $createdAt = $createdAt->format('Y-m-d\TH:i:s.000\Z');

        $parameters[] = [
            'name' => 'param_MODIF_TIMESTAMP',
            'value' => $createdAt
        ];

        $parameters[] = [
            'name' => 'param_MODIF_WOMASTER',
            'value' => $modifyWithoutMaster ? "true" : "false",
        ];

        $parameters[] = [
            'name' => 'param_MODIFICATION_INDEX',
            'value' => $invoice->getInvoiceDocumentReferences()->count() > 0
                ? "{$invoice->getInvoiceDocumentReferences()->count()}" : 'false',
        ];

        $lineReferenceMax = $invoice->getInvoiceReferenceAllLineCount();

        $parameters[] = [
            'name' => 'param_LINE_REFERENCE_MAX',
            'value' => $lineReferenceMax > 0 ? "{$lineReferenceMax}" : 'false',
        ];

        $customerPartyLegalEntity = $invoice->getAccountingCustomerParty()->getPartyLegalEntity();

        $isDomestic = false;
        if ($customerPartyLegalEntity->getRegistrationAddress()) {
            $isDomestic = $customerPartyLegalEntity->getRegistrationAddress()
                    ->getSpecificCountry()
                    ->getIdentificationCode() === 'HU';
        } elseif ($invoice->getAccountingCustomerParty()->getPostalAddress()) {
            $isDomestic = $invoice->getAccountingCustomerParty()
                    ->getPostalAddress()
                    ->getSpecificCountry()
                    ->getIdentificationCode() === 'HU';
        }

        $parameters[] = [
            'name' => 'param_CUSTOMER_IS_DOMESTIC',
            'value' =>
                $isDomestic
                && in_array(
                    $customerPartyLegalEntity->getCompanyLegalForm(),
                    [
                        CompanyLegalEnum::SELF_EMPLOYED,
                        CompanyLegalEnum::KKT,
                        CompanyLegalEnum::BT,
                        CompanyLegalEnum::KFT,
                        CompanyLegalEnum::ZRT,
                        CompanyLegalEnum::NYRT,
                        CompanyLegalEnum::OTHER
                    ]
                ) ? 'true' : 'false',
        ];

        $parameters[] = [
            'name' => 'param_CUSTOMER_IS_PRIVATE_PERSON',
            'value' =>
                in_array(
                    $customerPartyLegalEntity->getCompanyLegalForm(),
                    [
                        CompanyLegalEnum::PRIVATE_PERSON_WITH_VAT,
                        CompanyLegalEnum::PRIVATE_PERSON_WITHOUT_VAT
                    ]
                ) ? 'true' : 'false',
        ];

        $parameters[] = [
            'name' => 'param_CUSTOMER_IS_FOREIGN_LAND',
            'value' =>
                !$isDomestic
                && in_array(
                    $customerPartyLegalEntity->getCompanyLegalForm(),
                    [
                        CompanyLegalEnum::OTHER
                    ]
                ) ? 'true' : 'false'
        ];

        $parameters[] = [
            'name' => 'param_CUSTOMER_IS_EU_COMPANY',
            'value' => !$isDomestic && CountryChecker::isEUCountry($invoice->getAccountingCustomerParty()) ? 'true' : 'false'
        ];

        return $parameters;
    }

    /**
     * @param string|null $postalCode
     * @return string
     */
    private function transformPostalCode(?string $postalCode): string
    {
        return PostalCodeValidator::validate($postalCode) ? $postalCode : PostalCodeValidator::NON_INTERPRETED;
    }
}
