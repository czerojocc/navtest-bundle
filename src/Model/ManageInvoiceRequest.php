<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;

/**
 * Request root element of the POST /manageInvoice REST operation
 * Class ManageInvoiceRequest
 * @package Flexibill\NavBundle\Model
 */
class ManageInvoiceRequest implements NAVRequestInterface
{
    const PATH = 'manageInvoice';
    const TO_SEND_INVOICE_LIMIT = 50;

    use BasicRequestType;

    /**
     * @var string
     */
    protected $exchangeToken;

    /**
     * @var InvoiceOperationList
     */
    protected $invoiceOperations;

    /**
     * @return string
     */
    public function getExchangeToken(): ?string
    {
        return $this->exchangeToken;
    }

    /**
     * @param string $exchangeToken
     * @return $this
     */
    public function setExchangeToken(string $exchangeToken)
    {
        $this->exchangeToken = $exchangeToken;
        return $this;
    }

    /**
     * @return InvoiceOperationList
     */
    public function getInvoiceOperations(): ?InvoiceOperationList
    {
        return $this->invoiceOperations;
    }

    /**
     * @param InvoiceOperationList $invoiceOperations
     * @return $this
     */
    public function setInvoiceOperations(InvoiceOperationList $invoiceOperations)
    {
        $this->invoiceOperations = $invoiceOperations;
        return $this;
    }

}