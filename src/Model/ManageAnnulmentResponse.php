<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ManageAnnulmentResponse
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("ManageAnnulmentResponse")
 */
class ManageAnnulmentResponse extends AbstractNavTransactionResponse
{
    /**
     * @var Header
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
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     *
     * @return ManageAnnulmentResponse
     */
    public function setHeader(Header $header): ManageAnnulmentResponse
    {
        $this->header = $header;

        return $this;
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
     *
     * @return ManageAnnulmentResponse
     */
    public function setResult(BasicResult $result): ManageAnnulmentResponse
    {
        $this->result = $result;

        return $this;
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
     *
     * @return ManageAnnulmentResponse
     */
    public function setSoftware(Software $software): ManageAnnulmentResponse
    {
        $this->software = $software;

        return $this;
    }
}
