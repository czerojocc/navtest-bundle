<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class InvoiceNumberQuery
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceNumber")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $invoiceNumber;

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceDirection")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $invoiceDirection;

    /**
     * @var int
     *
     * Serializer\SerializedName("batchIndex")
     */
    protected $batchIndex;

    /**
     * @var string
     *
     * @Serializer\SerializedName("supplierTaxNumber")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $supplierTaxNumber;

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     *
     * @return InvoiceNumberQuery
     */
    public function setInvoiceNumber(string $invoiceNumber): InvoiceNumberQuery
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDirection(): string
    {
        return $this->invoiceDirection;
    }

    /**
     * @param string $invoiceDirection
     *
     * @return InvoiceNumberQuery
     */
    public function setInvoiceDirection(string $invoiceDirection): InvoiceNumberQuery
    {
        $this->invoiceDirection = $invoiceDirection;

        return $this;
    }

    /**
     * @return int
     */
    public function getBatchIndex(): int
    {
        return $this->batchIndex;
    }

    /**
     * @param int $batchIndex
     *
     * @return InvoiceNumberQuery
     */
    public function setBatchIndex(int $batchIndex): InvoiceNumberQuery
    {
        $this->batchIndex = $batchIndex;

        return $this;
    }

    /**
     * @return string
     */
    public function getSupplierTaxNumber(): string
    {
        return $this->supplierTaxNumber;
    }

    /**
     * @param string $supplierTaxNumber
     *
     * @return InvoiceNumberQuery
     */
    public function setSupplierTaxNumber(string $supplierTaxNumber): InvoiceNumberQuery
    {
        $this->supplierTaxNumber = $supplierTaxNumber;

        return $this;
    }
}
