<?php

namespace Flexibill\NavBundle\Service;

use Flexibill\NavBundle\Model\InvoiceIssueDate;
use Flexibill\NavBundle\Model\MandatoryQueryParams;

class MandatoryQueryParamsBuilder
{
    public static function buildByIssueDate(\DateTime $issueDateFrom, \DateTime $issueDateTo)
    {
        $mandatoryQueryParams = new MandatoryQueryParams();

        $invoiceIssueDate = new InvoiceIssueDate();

        $invoiceIssueDate->setDateFrom($issueDateFrom);
        $invoiceIssueDate->setDateTo($issueDateTo);

        $mandatoryQueryParams->setInvoiceIssueDate($invoiceIssueDate);

        return $mandatoryQueryParams;
    }

    public static function buildByInvoiceNumber(string $invoiceNumber)
    {
        $mandatoryQueryParams = new MandatoryQueryParams();

        $mandatoryQueryParams->setOriginalInvoiceNumber($invoiceNumber);

        return $mandatoryQueryParams;
    }

    public static function buildByInsDate(\DateTime $insDateFrom, \DateTime $insDateTo)
    {
        $mandatoryQueryParams = new MandatoryQueryParams();

        //@todo

        return $mandatoryQueryParams;
    }
}