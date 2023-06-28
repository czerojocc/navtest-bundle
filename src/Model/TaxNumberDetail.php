<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaxNumberDetail
 * @package Flexibill\NavBundle\Model
 */
class TaxNumberDetail
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("taxpayerId")
     * @Serializer\Type("string")
     */
    protected $taxpayerId;

    /**
     * @var string
     *
     * @Serializer\SerializedName("vatCode")
     * @Serializer\Type("string")
     */
    protected $vatCode;

    /**
     * @var string
     *
     * @Serializer\SerializedName("countyCode")
     * @Serializer\Type("string")
     */
    protected $countyCode;

    /**
     * @return string
     */
    public function getTaxpayerId(): string
    {
        return $this->taxpayerId;
    }

    /**
     * @param string $taxpayerId
     */
    public function setTaxpayerId(string $taxpayerId): void
    {
        $this->taxpayerId = $taxpayerId;
    }

    /**
     * @return string
     */
    public function getVatCode(): string
    {
        return $this->vatCode;
    }

    /**
     * @param string $vatCode
     */
    public function setVatCode(string $vatCode): void
    {
        $this->vatCode = $vatCode;
    }

    /**
     * @return string
     */
    public function getCountyCode(): string
    {
        return $this->countyCode;
    }

    /**
     * @param string $countyCode
     */
    public function setCountyCode(string $countyCode): void
    {
        $this->countyCode = $countyCode;
    }
}
