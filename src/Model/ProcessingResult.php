<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ProcessingResult
 * @package Flexibill\NavBundle\Model
 */
class ProcessingResult
{
    /**
     * @var int
     */
    protected $index;

    /**
     * @var string
     */
    protected $invoiceStatus;

    /**
     * @var ArrayCollection
     */
    protected $technicalValidationMessages;

    /**
     * @var ArrayCollection
     */
    protected $businessValidationMessages;

    /**
     * @var bool
     */
    protected $compressedContentIndicator;

    /**
     * @var string
     */
    protected $originalRequest;

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
    public function getInvoiceStatus(): ?string
    {
        return $this->invoiceStatus;
    }

    /**
     * @param string $invoiceStatus
     * @return $this
     */
    public function setInvoiceStatus(string $invoiceStatus)
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTechnicalValidationMessages(): ?ArrayCollection
    {
        return $this->technicalValidationMessages;
    }

    /**
     * @param ArrayCollection $technicalValidationMessages
     * @return $this
     */
    public function setTechnicalValidationMessages(ArrayCollection $technicalValidationMessages)
    {
        $this->technicalValidationMessages = $technicalValidationMessages;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBusinessValidationMessages(): ?ArrayCollection
    {
        return $this->businessValidationMessages;
    }

    /**
     * @param ArrayCollection $businessValidationMessages
     * @return $this
     */
    public function setBusinessValidationMessages(ArrayCollection $businessValidationMessages)
    {
        $this->businessValidationMessages = $businessValidationMessages;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCompressedContentIndicator(): ?bool
    {
        return $this->compressedContentIndicator;
    }

    /**
     * @param bool $compressedContentIndicator
     * @return $this
     */
    public function setCompressedContentIndicator(bool $compressedContentIndicator)
    {
        $this->compressedContentIndicator = $compressedContentIndicator;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalRequest(): ?string
    {
        return $this->originalRequest;
    }

    /**
     * @param string $originalRequest
     * @return $this
     */
    public function setOriginalRequest(string $originalRequest)
    {
        $this->originalRequest = $originalRequest;
        return $this;
    }
}