<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service\NavInvoiceParser;

use App\CompanyBundle\Model\CompanyInterface;
use App\InvoiceBundle\Enum\UnitOfMeasureTypeEnum;
use Doctrine\ORM\NonUniqueResultException;
use SimpleXMLElement;

class NavSimplifiedInvoiceParser extends NavInvoiceParser
{
    /**
     * @param array $invoiceArray
     * @param SimpleXMLElement $invoiceLines
     */
    protected function addInvoiceLines(array &$invoiceArray, SimpleXMLElement $invoiceLines)
    {
        $invoiceArray['invoiceLines'] = [];

        foreach ($invoiceLines->line as $line) {
            $invoiceLine = [
                'name' => (string)$line->lineDescription,
                'quantity' => $line->quantity ? (float)$line->quantity : 1,
                'unitCode' => $line->unitOfMeasure ? (string)$line->unitOfMeasure : UnitOfMeasureTypeEnum::PIECE,
                'ownUnitCode' => (string)$line->unitOfMeasureOwn,
            ];

            $vatContent = $line->lineAmountsSimplified->lineVatRate->vatContent ?? $line->lineAmountsSimplified->lineVatContent;

            if ($vatContent) {
                $invoiceLine['tax'] = (int)($this->parseTaxContent((float)$vatContent) * 100);
            } elseif ($vatExemption = $line->lineAmountsSimplified->lineVatRate->vatExemption) {
                $invoiceLine['tax'] = 0;
                $invoiceLine['navCase'] = (string)$vatExemption->case ?? null;
            } elseif ($vatOutOfScope = $line->lineAmountsSimplified->lineVatRate->vatOutOfScope) {
                $invoiceLine['tax'] = 0;
                $invoiceLine['navCase'] = (string)$vatOutOfScope->case ?? null;
            }

            if ($line->lineDiscountData) {
                $invoiceLine['discountValue'] = (float)$line->lineDiscountData->discountValue;
                $invoiceLine['discountDescription'] = (string)$line->lineDiscountData->discountDescription;
            }

            if ($vatContent) { // áfa összeg + nettó összeg
                $invoiceLine['taxAmount'] = $vatContent * (float)$line->lineAmountsSimplified->lineGrossAmountSimplified;
                $invoiceLine['lineExtensionAmount'] = (1 - $vatContent) * (float)$line->lineAmountsSimplified->lineGrossAmountSimplified;
                $invoiceLine['netUnitPrice'] = (1 - $vatContent) * (float)$line->unitPrice;
            } elseif ($line->lineAmountsSimplified->lineVatRate->vatExemption || $line->lineAmountsSimplified->lineVatRate->vatOutOfScope) {
                $invoiceLine['taxAmount'] = 0;
                $invoiceLine['lineExtensionAmount'] = (float)$line->lineAmountsSimplified->lineGrossAmountSimplified;
                $invoiceLine['netUnitPrice'] = (float)$line->unitPrice;
            }

            if ($line->lineAmountsSimplified->lineGrossAmountSimplified) { // bruttó összeg
                $invoiceLine['grossPriceAmount'] = (float)$line->lineAmountsSimplified->lineGrossAmountSimplified;
            } else {
                $invoiceLine['grossPriceAmount'] = $invoiceLine['lineExtensionAmount'] + $invoiceLine['taxAmount'];
            }

            $invoiceArray['invoiceLines'][] = $invoiceLine;
        }
    }

    protected function addInvoiceSummary(array &$invoiceArray, SimpleXMLElement $invoiceSummary)
    {
        $grossTotalAmount = isset($invoiceSummary->summaryGrossData->invoiceGrossAmount) ?
            (float)$invoiceSummary->summaryGrossData->invoiceGrossAmount : null;

        if (isset($invoiceSummary->summarySimplified)) {
            $netTotalAmount = 0;
            $grossTotalAmountHelper = 0;

            foreach ($invoiceSummary->summarySimplified as $summarySimplified) {
                $grossAmount = (float)$summarySimplified->vatContentGrossAmount;

                if (isset($summarySimplified->vatRate->vatContent)) {
                    $netAmount = (1 - (float)$summarySimplified->vatRate->vatContent) * $grossAmount;
                } else {
                    $netAmount = $grossAmount;
                }

                $netTotalAmount += $netAmount;
                $grossTotalAmountHelper += $grossAmount;
            }

            $grossTotalAmount = $grossTotalAmount ?? $grossTotalAmountHelper;

            $invoiceArray['grossTotalAmount'] = $grossTotalAmount;
            $invoiceArray['netTotalAmount'] = $netTotalAmount;
            $invoiceArray['taxTotalAmount'] = $grossTotalAmount - $netTotalAmount;
        }
    }

    protected function parseTaxContent(float $taxContent)
    {
        switch ($taxContent)
        {
            case 0: return 0;
            case 0.0476: return 0.05;
            case 0.1525: return 0.18;
            case 0.1667: return 0.2;
            case 0.2: return 0.25;
            case 0.2126: return 0.27;
            default: throw new \InvalidArgumentException('Cannot parse tax content');
        }
    }
}
