<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Service\SanitizeFromXmlNamespace;
use JMS\Serializer\Annotation as Serializer;
use SimpleXMLElement;

class InvoiceDataResult
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceData")
     * @Serializer\Type("string")
     */
    protected $invoiceData;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("compressedContentIndicator")
     * @Serializer\Type("bool")
     */
    protected $compressedContentIndicator;

    /**
     * @return string
     */
    public function getInvoiceData(): string
    {
        return $this->invoiceData;
    }

    public function getDecodedInvoiceData(): SimpleXMLElement
    {
        if ($this->isCompressedContentIndicator()) {
            $data = gzdecode(base64_decode($this->getInvoiceData()));
        } else {
            $data = base64_decode($this->getInvoiceData());
        }

        return new SimpleXMLElement(SanitizeFromXmlNamespace::sanitize($data));
    }

    /**
     * @param string $invoiceData
     *
     * @return InvoiceDataResult
     */
    public function setInvoiceData(string $invoiceData): InvoiceDataResult
    {
        $this->invoiceData = $invoiceData;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCompressedContentIndicator(): bool
    {
        return $this->compressedContentIndicator;
    }

    /**
     * @param bool $compressedContentIndicator
     */
    public function setCompressedContentIndicator(bool $compressedContentIndicator): void
    {
        $this->compressedContentIndicator = $compressedContentIndicator;
    }
}
