<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Service;
use Flexibill\NavBundle\Model\InvoiceOperation;
use Flexibill\NavBundle\Model\InvoiceOperationList;

/**
 * Class OperationManager
 * @package Flexibill\NavBundle\Service
 */
class OperationManager
{
    /**
     * @param string $operation
     * @param array $invoices
     * @param bool $compressed
     * @return InvoiceOperationList
     */
    public function init(
        string $operation,
        array $invoices,
        bool $compressed = false
    )
    {
        $invoiceOperationList = new InvoiceOperationList();
        $invoiceOperationList->setCompressedContent($compressed);

        /** @var string $invoice */
        foreach ($invoices as $invoice) {
            $invoiceOperation = new InvoiceOperation();
            $invoiceOperation->setOperation($operation);
            $invoiceOperation->setInvoice($invoice);
            //add invoice operation to the list
            $invoiceOperationList->addInvoiceOperation($invoiceOperation);
        }

        return $invoiceOperationList;
    }
}
