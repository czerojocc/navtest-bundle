<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\CompanyBundle\Model\CompanyInterface;
use Doctrine\ORM\NonUniqueResultException;
use SimpleXMLElement;

class NavInvoiceParser extends AbstractNavInvoiceParser
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
        $invoiceMain = $invoiceDataResult->invoiceMain;

        $invoiceHead = $invoiceMain->invoice->invoiceHead;
        $invoiceSummary = $invoiceMain->invoice->invoiceSummary;

        $invoiceData = $invoiceHead->invoiceDetail;
        $supplierInfo = $invoiceHead->supplierInfo;

        $issueDate = (string)$invoiceDataResult->invoiceIssueDate;
        $invoiceId = (string)$invoiceDataResult->invoiceNumber;

        $invoiceArray = $this->buildInvoiceArray(
            $company,
            $issueDate,
            $invoiceId,
            $invoiceData,
            $supplierInfo,
            $isInvoiceReload
        );

        if ($invoiceArray) {
            $this->addInvoiceLines($invoiceArray, $invoiceMain->invoice->invoiceLines);
            $this->addSupplierAddress($invoiceArray, $supplierInfo->supplierAddress);
            $this->addInvoiceSummary($invoiceArray, $invoiceSummary);
        }

        return $invoiceArray;
    }

    public function getInvoiceNumber(SimpleXMLElement $invoiceDataResult)
    {
        return (string)$invoiceDataResult->invoiceNumber;
    }

    public function getSupplierTaxNumberFromInvoiceData(SimpleXMLElement $invoiceDataResult)
    {
        $invoiceMain = $invoiceDataResult->invoiceMain;

        $invoiceHead = $invoiceMain->invoice->invoiceHead;

        $supplierInfo = $invoiceHead->supplierInfo;

        return $this->getSupplierTaxNumber($supplierInfo->supplierTaxNumber);
    }
}
