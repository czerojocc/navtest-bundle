<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class QueryInvoiceDigestResponse
 * @package Flexibill\NavBundle\Model
 */
class QueryInvoiceDigestResponse
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
     * @var InvoiceDigestResult|null
     *
     * @Serializer\SerializedName("invoiceDigestResult")
     * @Serializer\Type("Flexibill\NavBundle\Model\InvoiceDigestResult")
     */
    protected $invoiceDigestResult;

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
     * @return QueryInvoiceDigestResponse
     */
    public function setHeader(Header $header): QueryInvoiceDigestResponse
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
     * @return QueryInvoiceDigestResponse
     */
    public function setResult(BasicResult $result): QueryInvoiceDigestResponse
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
     * @return QueryInvoiceDigestResponse
     */
    public function setSoftware(Software $software): QueryInvoiceDigestResponse
    {
        $this->software = $software;

        return $this;
    }

    /**
     * @return InvoiceDigestResult|null
     */
    public function getInvoiceDigestResult(): ?InvoiceDigestResult
    {
        return $this->invoiceDigestResult;
    }

    /**
     * @param InvoiceDigestResult|null $invoiceDigestResult
     *
     * @return QueryInvoiceDigestResponse
     */
    public function setInvoiceDigestResult(?InvoiceDigestResult $invoiceDigestResult): QueryInvoiceDigestResponse
    {
        $this->invoiceDigestResult = $invoiceDigestResult;

        return $this;
    }
}
