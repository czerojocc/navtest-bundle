<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class InvoiceQueryDigestParams
 * @package Flexibill\NavBundle\Model
 */
class InvoiceQueryDigestParams
{
    /**
     * @var MandatoryQueryParams
     *
     * @Serializer\SerializedName("mandatoryQueryParams")
     */
    protected MandatoryQueryParams $mandatoryQueryParams;

    /**
     * @var AdditionalQueryParams|null
     *
     * @Serializer\SerializedName("additionalQueryParams")
     */
    protected ?AdditionalQueryParams $additionalQueryParams = null;

    /**
     * @return MandatoryQueryParams
     */
    public function getMandatoryQueryParams(): MandatoryQueryParams
    {
        return $this->mandatoryQueryParams;
    }

    /**
     * @param MandatoryQueryParams $mandatoryQueryParams
     *
     * @return InvoiceQueryDigestParams
     */
    public function setMandatoryQueryParams(MandatoryQueryParams $mandatoryQueryParams): InvoiceQueryDigestParams
    {
        $this->mandatoryQueryParams = $mandatoryQueryParams;

        return $this;
    }

    /**
     * @return AdditionalQueryParams|null
     */
    public function getAdditionalQueryParams(): ?AdditionalQueryParams
    {
        return $this->additionalQueryParams;
    }

    /**
     * @param AdditionalQueryParams|null $additionalQueryParams
     */
    public function setAdditionalQueryParams(?AdditionalQueryParams $additionalQueryParams): void
    {
        $this->additionalQueryParams = $additionalQueryParams;
    }
}
