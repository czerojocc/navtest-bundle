<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Response root element of the POST /queryInvoiceData REST operation
 * Class QueryInvoiceDataResponse
 * @package Flexibill\NavBundle\Model
 */
class QueryInvoiceDataResponse
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
     * @var InvoiceDataResult
     *
     * @Serializer\SerializedName("invoiceDataResult")
     * @Serializer\Type("Flexibill\NavBundle\Model\InvoiceDataResult")
     */
    protected $invoiceDataResult;

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
     * @return QueryInvoiceDataResponse
     */
    public function setHeader(Header $header): QueryInvoiceDataResponse
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
     * @return QueryInvoiceDataResponse
     */
    public function setResult(BasicResult $result): QueryInvoiceDataResponse
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
     * @return QueryInvoiceDataResponse
     */
    public function setSoftware(Software $software): QueryInvoiceDataResponse
    {
        $this->software = $software;

        return $this;
    }

    /**
     * @return InvoiceDataResult
     */
    public function getInvoiceDataResult(): InvoiceDataResult
    {
        return $this->invoiceDataResult;
    }

    /**
     * @param InvoiceDataResult $invoiceDataResult
     *
     * @return QueryInvoiceDataResponse
     */
    public function setInvoiceDataResult(InvoiceDataResult $invoiceDataResult): QueryInvoiceDataResponse
    {
        $this->invoiceDataResult = $invoiceDataResult;

        return $this;
    }
}
