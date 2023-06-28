<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\CompanyBundle\Model\CompanyInterface;
use App\InvoiceBundle\Builder\InvoiceDirector;
use App\InvoiceBundle\Entity\Invoice;
use Flexibill\NavBundle\Enum\StatusEnum;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;

class NavInvoiceParserFactory
{
    /**
     * @var NavLegacyInvoiceParser
     */
    private NavLegacyInvoiceParser $navLegacyInvoiceParser;

    /**
     * @var NavInvoiceParser
     */
    private NavInvoiceParser $navInvoiceParser;

    private NavSimplifiedInvoiceParser $navSimplifiedInvoiceParser;

    /**
     * NavInvoiceParserFactory constructor.
     *
     * @param NavLegacyInvoiceParser $navLegacyInvoiceParser
     * @param NavInvoiceParser $navInvoiceParser
     */
    public function __construct(
        NavLegacyInvoiceParser $navLegacyInvoiceParser,
        NavInvoiceParser $navInvoiceParser,
        NavSimplifiedInvoiceParser $navSimplifiedInvoiceParser
    )
    {
        $this->navLegacyInvoiceParser = $navLegacyInvoiceParser;
        $this->navInvoiceParser = $navInvoiceParser;
        $this->navSimplifiedInvoiceParser = $navSimplifiedInvoiceParser;
    }

    /**
     * @param SimpleXMLElement $invoiceData
     * @return Invoice|null
     */
    public function getParser(SimpleXMLElement $invoiceData): ?AbstractNavInvoiceParser
    {
        $invoiceExchange = $invoiceData->invoiceExchange;
        $invoiceMain = $invoiceData->invoiceMain;

        if (
            $invoiceExchange->count() > 0
            && (string)$invoiceExchange->invoiceHead->invoiceData->invoiceCategory === 'NORMAL'
        ) {
            return $this->navLegacyInvoiceParser;
        }

        // @todo handle aggregate specific data on invoices
        if (
            $invoiceMain->count() > 0
            && ((string)$invoiceMain->invoice->invoiceHead->invoiceDetail->invoiceCategory === 'NORMAL'
            || (string)$invoiceMain->invoice->invoiceHead->invoiceDetail->invoiceCategory === 'AGGREGATE')
        ) {
            return $this->navInvoiceParser;
        }

        if (
            $invoiceMain->count() > 0
            && (string)$invoiceMain->invoice->invoiceHead->invoiceDetail->invoiceCategory === 'SIMPLIFIED'
        ) {
            return $this->navSimplifiedInvoiceParser;
        }

        return null;
    }
}
