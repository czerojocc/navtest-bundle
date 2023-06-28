<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\AppBundle\Service\ChoiceOptionAliasResolver;
use App\CompanyBundle\Enum\CompanyLegalEnum;
use App\CompanyBundle\Model\CompanyInterface;
use App\InvoiceBundle\Entity\Address;
use App\InvoiceBundle\Entity\AddressInterface;
use App\InvoiceBundle\Entity\Invoice;
use App\InvoiceBundle\Entity\Party;
use App\InvoiceBundle\Enum\InvoiceTypeEnum;
use App\InvoiceBundle\Enum\PaymentModeEnum;
use App\InvoiceBundle\Enum\UnitOfMeasureTypeEnum;
use Flexibill\NavBundle\Exception\InvoiceAlreadyExistsException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;

abstract class AbstractNavInvoiceParser implements NavInvoiceParserInterface
{
    const ADDRESS_TYPE_SIMPLE = 'simple';
    const ADDRESS_TYPE_DETAILED = 'detailed';

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * AbstractNavInvoiceParser constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface        $logger
    )
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    protected function addInvoiceSummary(array &$invoiceArray, SimpleXMLElement $invoiceSummary)
    {
        $summaryNormal = $invoiceSummary->summaryNormal ?? null;
        $grossTotalAmount = isset($invoiceSummary->summaryGrossData->invoiceGrossAmount) ?
            (float)$invoiceSummary->summaryGrossData->invoiceGrossAmount : null;

        if ($summaryNormal) {
            $invoiceArray['netTotalAmount'] = (float)$invoiceSummary->summaryNormal->invoiceNetAmount;
            $invoiceArray['taxTotalAmount'] = (float)$invoiceSummary->summaryNormal->invoiceVatAmount;
            $invoiceArray['grossTotalAmount'] = $grossTotalAmount ?? ($invoiceArray['netTotalAmount'] + $invoiceArray['taxTotalAmount']);
        }
    }

    /**
     * @param array $invoiceArray
     * @param SimpleXMLElement $invoiceLines
     */
    protected function addInvoiceLines(array &$invoiceArray, SimpleXMLElement $invoiceLines)
    {
        $invoiceArray['invoiceLines'] = [];

        foreach ($invoiceLines->line as $line) {
            $unitCode = $line->unitOfMeasure ? trim((string)$line->unitOfMeasure) : UnitOfMeasureTypeEnum::PIECE;
            $ownUnitCode = null;
            try {
                $unitCode = ChoiceOptionAliasResolver::resolve($unitCode, UnitOfMeasureTypeEnum::class);
            } catch (\Exception $exception) {
                $ownUnitCode = $unitCode;
            }

            $invoiceLine = [
                'name' => (string)$line->lineDescription,
                'netUnitPrice' => (float)$line->unitPrice,
                'quantity' => $line->quantity ? (float)$line->quantity : 1,
                'unitCode' => $ownUnitCode ? UnitOfMeasureTypeEnum::OWN : $unitCode,
                'ownUnitCode' => $ownUnitCode ?? (string)$line->unitOfMeasureOwn,
            ];

            if ($line->lineAmountsNormal->lineVatRate->vatPercentage) {
                $invoiceLine['tax'] = (int)((float)$line->lineAmountsNormal->lineVatRate->vatPercentage * 100);
            } elseif ($vatExemption = $line->lineAmountsNormal->lineVatRate->vatExemption) {
                $invoiceLine['tax'] = 0;
                $invoiceLine['navCase'] = (string)$vatExemption->case ?? null;
            } elseif ($vatOutOfScope = $line->lineAmountsNormal->lineVatRate->vatOutOfScope) {
                $invoiceLine['tax'] = 0;
                $invoiceLine['navCase'] = (string)$vatOutOfScope->case ?? null;
            } elseif ($line->lineAmountsNormal->lineVatData && (float)$line->lineAmountsNormal->lineVatData->lineVatAmount == 0) {
                $invoiceLine['tax'] = 0;
            }

            if ($line->lineDiscountData) {
                $invoiceLine['discountValue'] = (float)$line->lineDiscountData->discountValue;
                $invoiceLine['discountDescription'] = (string)$line->lineDiscountData->discountDescription;
            }

            $netAmount = $line->lineAmountsNormal->lineNetAmountData->lineNetAmount ?? $line->lineAmountsNormal->lineNetAmount;

            if ($netAmount) { //nettó összeg
                $invoiceLine['lineExtensionAmount'] = (float)$netAmount;
            }

            if ($line->lineAmountsNormal->lineVatData) { //áfa összeg
                $invoiceLine['taxAmount'] = (float)$line->lineAmountsNormal->lineVatData->lineVatAmount;
            } elseif ($line->lineAmountsNormal->lineVatRate->vatExemption || $line->lineAmountsNormal->lineVatRate->vatOutOfScope) {
                $invoiceLine['taxAmount'] = 0;
            } elseif ($line->lineAmountsNormal->lineVatRate->vatPercentage) {
                $invoiceLine['taxAmount'] = (float)$netAmount * $line->lineAmountsNormal->lineVatRate->vatPercentage;
            }

            if ($line->lineAmountsNormal->lineGrossAmountData) { //bruttó összeg
                $invoiceLine['grossPriceAmount'] = (float)$line->lineAmountsNormal->lineGrossAmountData->lineGrossAmountNormal;
            } else {
                $invoiceLine['grossPriceAmount'] = $invoiceLine['lineExtensionAmount'] + $invoiceLine['taxAmount'];
            }

            $invoiceArray['invoiceLines'][] = $invoiceLine;
        }
    }

    /**
     * @param array $invoiceArray
     * @param SimpleXMLElement $supplierAddress
     */
    protected function addSupplierAddress(array &$invoiceArray, SimpleXMLElement $supplierAddress): void
    {
        if ($supplierAddress->simpleAddress) {
            $address = $this->buildAddress($supplierAddress->simpleAddress, self::ADDRESS_TYPE_SIMPLE);
        } else {
            $address = $this->buildAddress($supplierAddress->detailedAddress, self::ADDRESS_TYPE_DETAILED);
        }

        $invoiceArray['supplier']['postalAddress'] = $address;
        $invoiceArray['supplier']['registrationAddress'] = $address;
    }

    /**
     * @param SimpleXMLElement $supplierTaxNumber
     *
     * @return string
     */
    protected function getSupplierTaxNumber(SimpleXMLElement $supplierTaxNumber): string
    {
        if (
            $supplierTaxNumber->taxpayerId
            && $supplierTaxNumber->vatCode
            && $supplierTaxNumber->countyCode
        ) {
            $supplierTaxNumber = sprintf(
                '%s-%s-%s',
                $supplierTaxNumber->taxpayerId,
                $supplierTaxNumber->vatCode,
                $supplierTaxNumber->countyCode,
            );
        } else {
            $supplierTaxNumber = $supplierTaxNumber->taxpayerId;

            if (!is_string($supplierTaxNumber)) {
                $supplierTaxNumber = $supplierTaxNumber->__toString();
            }
        }

        return $supplierTaxNumber;
    }

    /**
     * @param string $taxNumber
     *
     * @return Party|object|null
     */
    protected function getSupplierByTaxNumber(string $taxNumber): ?Party
    {
        return $this->entityManager->getRepository(Party::class)->findOneBy(
            [
                'taxNumber' => $taxNumber,
            ]
        );
    }

    /**
     * @param string $invoiceNumber
     * @param string $taxNumber
     *
     * @return Invoice|null
     * @throws NonUniqueResultException
     */
    public function getExistingInvoiceByInvoiceNumberAndSupplier(string $invoiceNumber, string $taxNumber): ?Invoice
    {
        /** @var QueryBuilder $qb */
        $qb = $this->entityManager->getRepository(Invoice::class)->createQueryBuilder('invoice');

        return $qb
            ->leftJoin('invoice.accountingSupplierParty', 'accountingSupplierParty')
            ->andWhere('invoice.invoiceId = :invoiceId')
            ->andWhere('accountingSupplierParty.taxNumber = :taxNumber')
            ->setParameters(
                [
                    'invoiceId' => $invoiceNumber,
                    'taxNumber' => $taxNumber
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param SimpleXMLElement $element
     *
     * @return bool
     */
    protected function getBoolValue(SimpleXMLElement $element): bool
    {
        return (string)$element === 'false' ? false : true;
    }

    /**
     * @param string $method
     *
     * @return string|int
     */
    protected function transformPaymentMethod(string $method)
    {
        switch ($method) {
            case 'TRANSFER':
                return PaymentModeEnum::BANK_TRANSFER;
            case 'CASH':
                return PaymentModeEnum::CASH;
            case 'CARD':
                return PaymentModeEnum::BANK_CARD;
            case 'VOUCHER':
                return PaymentModeEnum::VOUCHER;
        }

        return PaymentModeEnum::OTHER;
    }

    /**
     * @param Address|AddressInterface $address
     *
     * @return array
     */
    protected function getAddressFromEntity(Address $address): array
    {
        return [
            'country' => $address->getCountry(),
            'postalCode' => $address->getPostalZone(),
            'city' => $address->getCityName(),
            'district' => $address->getDistrict(),
            'street' => $address->getStreetName(),
            'buildingNumber' => $address->getBuildingNumber(),
            'floor' => $address->getFloor(),
            'door' => $address->getRoom(),
            'addressLine' => $address->getAddressLine(),
        ];
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function parseName(string $name): string
    {
        $name = explode(' ', mb_strtolower($name));

        foreach ($name as $key => $part) {
            $name[$key] = ucfirst($part);
        }

        return join(' ', $name);
    }

    /**
     * @param CompanyInterface $company
     * @param string $issueDate
     * @param string $invoiceId
     * @param SimpleXMLElement $invoiceData
     * @param SimpleXMLElement $supplierInfo
     * @param bool $isInvoiceReload
     *
     * @return array
     * @throws NonUniqueResultException|InvoiceAlreadyExistsException
     */
    protected function buildInvoiceArray(
        CompanyInterface $company,
        string           $issueDate,
        string           $invoiceId,
        SimpleXMLElement $invoiceData,
        SimpleXMLElement $supplierInfo,
        bool             $isInvoiceReload = false
    ): array
    {
        $supplierTaxNumber = $supplierInfo->supplierTaxNumber;
        $supplierTaxNumber = $this->getSupplierTaxNumber($supplierTaxNumber);

        $supplier = $this->getSupplierByTaxNumber($supplierTaxNumber);

        /**
         * If invoice number by this supplier exists in our database we have to skip invoice saving,
         * but we add current company to existing invoice as customer company
         *
         * @todo handle outgoing invoices too
         */
        if (($invoice = $this->getExistingInvoiceByInvoiceNumberAndSupplier($invoiceId, $supplierTaxNumber)) && !$isInvoiceReload) {
            if (!$invoice->getCustomerCompany()) {
                $invoice->setCustomerCompany($company);

                $this->entityManager->persist($invoice);
                $this->entityManager->flush();
            }

            $this->logger->info(sprintf('invoice already exists with id: %s, and supplier tax number: %s', $invoiceId, $supplierTaxNumber));

            throw new InvoiceAlreadyExistsException();
        }

        return [
            'isExternalInvoice' => true,
            'draft' => false,
            'selfBilling' => $this->getBoolValue($invoiceData->selfBillingIndicator),
            'thirdPartyInvoice' => false,
            'customer' => [
                'name' => $company->getName(),
                'taxNumber' => $company->getParty()->getTaxNumber(),
                'euTaxNumber' => $company->getParty()->getEuTaxNumber(),
                'groupTaxNumber' => $company->getParty()->getGroupTaxNumber(),
                'thirdStateTaxNumber' => $company->getParty()->getThirdStateTaxNumber(),
                'email' => $company->getEmail(),
                'telephone' => $company->getParty()->getContact()->getTelephone(),
                'companyLegalForm' => $company->getParty()->getPartyLegalEntity()->getCompanyLegalForm(),
                'postalAddress' => $this->getAddressFromEntity($company->getParty()->getPostalAddress()),
                'registrationAddress' => $this->getAddressFromEntity(
                    $company->getParty()->getPartyLegalEntity()->getRegistrationAddress()
                ),
            ],
            'supplier' => [
                'name' => $supplier ? $supplier->getPartyName() : $this->parseName(
                    (string)$supplierInfo->supplierName
                ),
                'taxNumber' => $supplier ? $supplier->getTaxNumber() : $supplierTaxNumber,
                'euTaxNumber' => $supplier ? $supplier->getEuTaxNumber() : (string)$supplierInfo->communityVatNumber,
                'groupTaxNumber' => $supplier ? $supplier->getGroupTaxNumber() : (string)$supplierInfo->groupMemberTaxNumber,
                'email' => $supplier && $supplier->getContact() ? $supplier->getContact()->getElectronicMail() : '',
                'telephone' => $supplier && $supplier->getContact() ? $supplier->getContact()->getTelephone() : '',
                'companyLegalForm' => $supplier ? $supplier->getPartyLegalEntity()->getCompanyLegalForm() : CompanyLegalEnum::OTHER,
            ],
            'issueDate' => $issueDate,
            'dueDate' => (string)$invoiceData->paymentDate,
            'taxPointDate' => (string)$invoiceData->invoiceDeliveryDate,
            'invoiceTypeCode' => InvoiceTypeEnum::SALES_INVOICE,
            'eInvoice' => (string)$invoiceData->invoiceAppearance === 'PAPER' ? false : true,
            'language' => 'HU',
            'documentCurrencyCode' => (string)$invoiceData->currencyCode,
            'paymentMode' => $this->transformPaymentMethod((string)$invoiceData->paymentMethod),
            'calculationRate' => (int)$invoiceData->exchangeRate,
            'cashAccounting' => $this->getBoolValue($invoiceData->cashAccountingIndicator),
            'invoicePeriodStart' => (string)$invoiceData->invoiceDeliveryPeriodStart,
            'invoicePeriodEnd' => (string)$invoiceData->invoiceDeliveryPeriodEnd,
            'invoiceId' => $invoiceId,
        ];
    }

    /**
     * @param SimpleXMLElement $element
     * @param $type
     *
     * @return string[]
     */
    private function buildAddress(SimpleXMLElement $element, $type): array
    {
        if ($type === self::ADDRESS_TYPE_SIMPLE) {
            return [
                'country' => (string)$element->countryCode,
                'postalCode' => (string)$element->postalCode,
                'city' => (string)$element->city,
                'addressLine' => (string)$element->additionalAddressDetail,
            ];
        } else {
            return [
                'country' => (string)$element->countryCode,
                'postalCode' => (string)$element->postalCode,
                'city' => (string)$element->city,
                'street' => (string)$element->streetName,
                'streetType' => (string)$element->publicPlaceCategory,
                'buildingNumber' => (string)$element->number,
                'floor' => (string)$element->floor,
                'door' => (string)$element->door,
            ];
        }
    }

    abstract public function getInvoiceNumber(SimpleXMLElement $invoiceDataResult);
    abstract public function getSupplierTaxNumberFromInvoiceData(SimpleXMLElement $invoiceDataResult);
}
