<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class QueryTaxpayerRequest
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("QueryTaxpayerRequest")
 * @Serializer\XmlNamespace("http://schemas.nav.gov.hu/OSA/3.0/api")
 * @Serializer\XmlNamespace(uri="http://schemas.nav.gov.hu/NTCA/1.0/common", prefix="common")
 * @Serializer\AccessorOrder("custom", custom={"header", "user", "software", "taxNumber"})
 */
class QueryTaxpayerRequest implements NAVRequestInterface
{
    const PATH = 'queryTaxpayer';

    use BasicRequestType;

    /**
     * @var HeaderInterface
     *
     * @Serializer\XmlElement(cdata=false, namespace="http://schemas.nav.gov.hu/NTCA/1.0/common")
     */
    protected $header;

    /**
     * @var User
     *
     * @Serializer\XmlElement(cdata=false, namespace="http://schemas.nav.gov.hu/NTCA/1.0/common")
     */
    protected $user;

    /**
     * @var string
     *
     * @Serializer\SerializedName("taxNumber")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $taxNumber;

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     *
     * @return QueryTaxpayerRequest
     */
    public function setTaxNumber(string $taxNumber): QueryTaxpayerRequest
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }
}
