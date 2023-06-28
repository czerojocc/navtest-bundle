<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class AnnulmentOperation
 * @package Flexibill\NavBundle\Model
 */
class AnnulmentOperation
{
    /**
     * @var int
     *
     * @Serializer\SerializedName("index")
     */
    protected $index;

    /**
     * @var string
     *
     * @Serializer\SerializedName("annulmentOperation")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $annulmentOperation = 'ANNUL';

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceAnnulment")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $invoiceAnnulment;

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param int $index
     *
     * @return AnnulmentOperation
     */
    public function setIndex(int $index): AnnulmentOperation
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnnulmentOperation(): string
    {
        return $this->annulmentOperation;
    }

    /**
     * @param string $annulmentOperation
     *
     * @return AnnulmentOperation
     */
    public function setAnnulmentOperation(string $annulmentOperation): AnnulmentOperation
    {
        $this->annulmentOperation = $annulmentOperation;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceAnnulment(): string
    {
        return $this->invoiceAnnulment;
    }

    /**
     * @param string $invoiceAnnulment
     *
     * @return AnnulmentOperation
     */
    public function setInvoiceAnnulment(string $invoiceAnnulment): AnnulmentOperation
    {
        $this->invoiceAnnulment = $invoiceAnnulment;

        return $this;
    }
}
