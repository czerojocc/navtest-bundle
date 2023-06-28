<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class QueryInvoiceDigestRequest
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("QueryInvoiceDigestRequest")
 * @Serializer\XmlNamespace("http://schemas.nav.gov.hu/OSA/3.0/api")
 * @Serializer\XmlNamespace(uri="http://schemas.nav.gov.hu/NTCA/1.0/common", prefix="common")
 * @Serializer\AccessorOrder("custom", custom={"header", "user", "software", "page", "invoiceDirection", "invoiceQueryParams"})
 */
class QueryInvoiceDigestRequest
{
    const PATH = 'queryInvoiceDigest';

    const DIRECTION_OUTBOUND = 'OUTBOUND';
    const DIRECTION_INBOUND = 'INBOUND';

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
     * @var int
     */
    protected $page;

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceDirection")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $invoiceDirection;

    /**
     * @var InvoiceQueryDigestParams
     *
     * @Serializer\SerializedName("invoiceQueryParams")
     */
    protected $invoiceQueryParams;

    /**
     * QueryInvoiceDigestRequest constructor.
     */
    public function __construct()
    {
        $this->page = 1;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return QueryInvoiceDigestRequest
     */
    public function setPage(int $page): QueryInvoiceDigestRequest
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDirection(): string
    {
        return $this->invoiceDirection;
    }

    /**
     * @param string $invoiceDirection
     *
     * @return QueryInvoiceDigestRequest
     */
    public function setInvoiceDirection(string $invoiceDirection): QueryInvoiceDigestRequest
    {
        $this->invoiceDirection = $invoiceDirection;

        return $this;
    }

    /**
     * @return InvoiceQueryDigestParams
     */
    public function getInvoiceQueryParams(): InvoiceQueryDigestParams
    {
        return $this->invoiceQueryParams;
    }

    /**
     * @param InvoiceQueryDigestParams $invoiceQueryParams
     *
     * @return QueryInvoiceDigestRequest
     */
    public function setInvoiceQueryParams(InvoiceQueryDigestParams $invoiceQueryParams): QueryInvoiceDigestRequest
    {
        $this->invoiceQueryParams = $invoiceQueryParams;

        return $this;
    }
}
