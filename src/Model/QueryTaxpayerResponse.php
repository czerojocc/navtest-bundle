<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class QueryTaxpayerResponse
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("QueryTaxpayerResponse")
 */
class QueryTaxpayerResponse
{
    /**
     * @var Header
     *
     * @Serializer\Type("Flexibill\NavBundle\Model\Header")
     */
    protected $header;

    /**
     * @var BasicResult
     *
     * @Serializer\Type("Flexibill\NavBundle\Model\BasicResult")
     */
    protected $result;

    /**
     * @var Software
     *
     * @Serializer\Type("Flexibill\NavBundle\Model\Software")
     */
    protected $software;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("infoDate")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("DateTime<'Y-m-d\TH:i:s.vP'>")
     */
    protected $infoDate;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("taxpayerValidity")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("bool")
     */
    protected $validTaxpayer;

    /**
     * @var TaxpayerData|null
     *
     * @Serializer\SerializedName("taxpayerData")
     * @Serializer\Type("Flexibill\NavBundle\Model\TaxpayerData")
     */
    protected $taxpayerData;

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     */
    public function setHeader(Header $header): void
    {
        $this->header = $header;
    }

    /**
     * @return BasicResult
     */
    public function getResult(): BasicResult
    {
        return $this->result;
    }

    /**
     * @param BasicResult $result
     */
    public function setResult(BasicResult $result): void
    {
        $this->result = $result;
    }

    /**
     * @return Software
     */
    public function getSoftware(): Software
    {
        return $this->software;
    }

    /**
     * @param Software $software
     */
    public function setSoftware(Software $software): void
    {
        $this->software = $software;
    }

    /**
     * @return DateTime
     */
    public function getInfoDate(): DateTime
    {
        return $this->infoDate;
    }

    /**
     * @param DateTime $infoDate
     */
    public function setInfoDate(DateTime $infoDate): void
    {
        $this->infoDate = $infoDate;
    }

    /**
     * @return bool
     */
    public function isValidTaxpayer(): bool
    {
        if (
            $this->getResult()->getErrorCode() === 'NOT_REGISTERED_CUSTOMER'
            || $this->validTaxpayer === null
        ) {
            return false;
        }

        return $this->validTaxpayer;
    }

    /**
     * @param bool $validTaxpayer
     */
    public function setValidTaxpayer(bool $validTaxpayer): void
    {
        $this->validTaxpayer = $validTaxpayer;
    }

    /**
     * @return TaxpayerData|null
     */
    public function getTaxpayerData(): ?TaxpayerData
    {
        return $this->taxpayerData;
    }

    /**
     * @param TaxpayerData|null $taxpayerData
     */
    public function setTaxpayerData(?TaxpayerData $taxpayerData): void
    {
        $this->taxpayerData = $taxpayerData;
    }
}
