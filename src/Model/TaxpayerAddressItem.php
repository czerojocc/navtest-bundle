<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaxpayerAddressItem
 * @package Flexibill\NavBundle\Model
 */
class TaxpayerAddressItem
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("taxpayerAddressType")
     * @Serializer\Type("string")
     */
    protected $taxpayerAddressType;

    /**
     * @var TaxpayerAddress
     *
     * @Serializer\SerializedName("taxpayerAddress")
     * @Serializer\Type("Flexibill\NavBundle\Model\TaxpayerAddress")
     */
    protected $taxpayerAddress;

    /**
     * @return string
     */
    public function getTaxpayerAddressType(): string
    {
        return $this->taxpayerAddressType;
    }

    /**
     * @param string $taxpayerAddressType
     */
    public function setTaxpayerAddressType(string $taxpayerAddressType): void
    {
        $this->taxpayerAddressType = $taxpayerAddressType;
    }

    /**
     * @return TaxpayerAddress
     */
    public function getTaxpayerAddress(): TaxpayerAddress
    {
        return $this->taxpayerAddress;
    }

    /**
     * @param TaxpayerAddress $taxpayerAddress
     */
    public function setTaxpayerAddress(TaxpayerAddress $taxpayerAddress): void
    {
        $this->taxpayerAddress = $taxpayerAddress;
    }
}
