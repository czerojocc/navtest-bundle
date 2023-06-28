<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\CompanyBundle\Model\CompanyInterface;
use Doctrine\ORM\NonUniqueResultException;
use SimpleXMLElement;

class NavLegacyInvoiceParser extends AbstractNavInvoiceParser
{
    /**
     * @param CompanyInterface $company
     * @param SimpleXMLElement $invoiceDataResult
     * @param bool $isInvoiceReload
     *
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function parse(
        CompanyInterface $company,
        SimpleXMLElement $invoiceDataResult,
        bool $isInvoiceReload = false
    ): ?array
    {
        $invoiceExchange = $invoiceDataResult->invoiceExchange;

        $invoiceHead = $invoiceExchange->invoiceHead;

        $invoiceData = $invoiceHead->invoiceData;
        $supplierInfo = $invoiceHead->supplierInfo;

        $issueDate = (string)$invoiceData->invoiceIssueDate;
        $invoiceId = (string)$invoiceData->invoiceNumber;

        $invoiceArray = $this->buildInvoiceArray(
            $company,
            $issueDate,
            $invoiceId,
            $invoiceData,
            $supplierInfo,
            $isInvoiceReload
        );

        if ($invoiceArray) {
            $this->addInvoiceLines($invoiceArray, $invoiceExchange->invoiceLines);
            $this->addSupplierAddress($invoiceArray, $supplierInfo->supplierAddress);
        }

        return $invoiceArray;
    }

    public function getInvoiceNumber(SimpleXMLElement $invoiceDataResult)
    {
        $invoiceExchange = $invoiceDataResult->invoiceExchange;

        $invoiceHead = $invoiceExchange->invoiceHead;

        $invoiceData = $invoiceHead->invoiceData;

        return (string)$invoiceData->invoiceNumber;
    }

    public function getSupplierTaxNumberFromInvoiceData(SimpleXMLElement $invoiceDataResult)
    {
        $invoiceExchange = $invoiceDataResult->invoiceExchange;

        $invoiceHead = $invoiceExchange->invoiceHead;

        $supplierInfo = $invoiceHead->supplierInfo;

        return $this->getSupplierTaxNumber($supplierInfo->supplierTaxNumber);
    }
}
