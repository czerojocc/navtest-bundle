<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaxpayerData
 * @package Flexibill\NavBundle\Model
 */
class TaxpayerData
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("taxpayerName")
     * @Serializer\Type("string")
     */
    protected $taxpayerName;

    /**
     * @var TaxNumberDetail
     *
     * @Serializer\SerializedName("taxNumberDetail")
     * @Serializer\Type("Flexibill\NavBundle\Model\TaxNumberDetail")
     */
    protected $taxNumberDetail;

    /**
     * @var string
     *
     * @Serializer\SerializedName("incorporation")
     * @Serializer\Type("string")
     */
    protected $incorporation;

    /**
     * @var TaxpayerAddressList
     *
     * @Serializer\SerializedName("taxpayerAddressList")
     * @Serializer\Type("Flexibill\NavBundle\Model\TaxpayerAddressList")
     */
    protected $taxpayerAddressList;

    /**
     * @return string
     */
    public function getTaxpayerName(): string
    {
        return $this->taxpayerName;
    }

    /**
     * @param string $taxpayerName
     */
    public function setTaxpayerName(string $taxpayerName): void
    {
        $this->taxpayerName = $taxpayerName;
    }

    /**
     * @return TaxNumberDetail
     */
    public function getTaxNumberDetail(): TaxNumberDetail
    {
        return $this->taxNumberDetail;
    }

    /**
     * @param TaxNumberDetail $taxNumberDetail
     */
    public function setTaxNumberDetail(TaxNumberDetail $taxNumberDetail): void
    {
        $this->taxNumberDetail = $taxNumberDetail;
    }

    /**
     * @return string
     */
    public function getIncorporation(): string
    {
        return $this->incorporation;
    }

    /**
     * @param string $incorporation
     */
    public function setIncorporation(string $incorporation): void
    {
        $this->incorporation = $incorporation;
    }

    /**
     * @return TaxpayerAddressList
     */
    public function getTaxpayerAddressList(): TaxpayerAddressList
    {
        return $this->taxpayerAddressList;
    }

    /**
     * @param TaxpayerAddressList $taxpayerAddressList
     */
    public function setTaxpayerAddressList(TaxpayerAddressList $taxpayerAddressList): void
    {
        $this->taxpayerAddressList = $taxpayerAddressList;
    }
}
