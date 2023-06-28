<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class InvoiceOperation
 * @package Flexibill\NavBundle\Model
 */
class InvoiceOperation
{
    /**
     * Sequence number of the invoice within the request
     * @var int
     */
    protected $index;

    /**
     * Type of the desired operation
     * @var string
     */
    protected $operation;

    /**
     * base64decodedInvoiceData
     * @var string
     */
    protected $invoice;

    /**
     * @return int
     */
    public function getIndex(): ?int
    {
        return $this->index;
    }

    /**
     * @param int $index
     * @return $this
     */
    public function setIndex(int $index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperation(): ?string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     * @return $this
     */
    public function setOperation(string $operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    /**
     * @param string $invoice
     * @return $this
     */
    public function setInvoice(string $invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }
}