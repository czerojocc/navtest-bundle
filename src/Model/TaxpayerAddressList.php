<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaxpayerAddressList
 * @package Flexibill\NavBundle\Model
 */
class TaxpayerAddressList
{
    /**
     * @var TaxpayerAddressItem[]|array
     *
     * @Serializer\XmlList(inline=true, entry="taxpayerAddressItem")
     * @Serializer\Type("array<Flexibill\NavBundle\Model\TaxpayerAddressItem>")
     */
    protected $taxpayerAddressItems;

    /**
     * @return TaxpayerAddressItem[]|array
     */
    public function getTaxpayerAddressItems(): array
    {
        return $this->taxpayerAddressItems;
    }

    /**
     * @param TaxpayerAddressItem[]|array $taxpayerAddressItems
     */
    public function setTaxpayerAddressItems(array $taxpayerAddressItems): void
    {
        $this->taxpayerAddressItems = $taxpayerAddressItems;
    }
}
