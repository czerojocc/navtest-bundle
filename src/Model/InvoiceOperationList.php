<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InvoiceOperations
 * @package Flexibill\NavBundle\Model
 */
class InvoiceOperationList
{
    /**
     * Compressed content indicator for the processing flow
     * @var boolean
     */
    protected $compressedContent;

    /**
     *
     * @var ArrayCollection
     */
    protected $invoiceOperations;

    /**
     * InvoiceOperationList constructor.
     */
    public function __construct()
    {
        $this->invoiceOperations = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function isCompressedContent(): ?bool
    {
        return $this->compressedContent;
    }

    /**
     * @param bool $compressedContent
     * @return $this
     */
    public function setCompressedContent(bool $compressedContent)
    {
        $this->compressedContent = $compressedContent;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getInvoiceOperations(): ?ArrayCollection
    {
        return $this->invoiceOperations;
    }

    /**
     * @param ArrayCollection $invoiceOperations
     * @return $this
     */
    public function setInvoiceOperations(ArrayCollection $invoiceOperations)
    {
        $this->invoiceOperations = $invoiceOperations;
        return $this;
    }

    /**
     * @param InvoiceOperation $element
     * @return $this
     */
    public function addInvoiceOperation(InvoiceOperation $element)
    {
        $element->setIndex($this->invoiceOperations->count() + 1);
        $this->invoiceOperations->add($element);
        return $this;
    }

    /**
     * @param InvoiceOperation $element
     * @return $this
     */
    public function removeInvoiceOperation(InvoiceOperation $element)
    {
        $this->invoiceOperations->removeElement($element);
        return $this;
    }
}
