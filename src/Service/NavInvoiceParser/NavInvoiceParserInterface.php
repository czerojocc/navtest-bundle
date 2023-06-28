<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\CompanyBundle\Model\CompanyInterface;
use SimpleXMLElement;

interface NavInvoiceParserInterface
{
    /**
     * @param CompanyInterface $company
     * @param SimpleXMLElement $invoiceDataResult
     * @param bool $isInvoiceReload
     *
     * @return array|null
     */
    public function parse(
        CompanyInterface $company,
        SimpleXMLElement $invoiceDataResult,
        bool $isInvoiceReload = false
    ): ?array;
}
