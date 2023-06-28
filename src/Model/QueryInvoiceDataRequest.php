<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Request root element of the queryInvoiceData REST operation
 *
 * Class QueryInvoiceDataRequest
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("QueryInvoiceDataRequest")
 * @Serializer\XmlNamespace("http://schemas.nav.gov.hu/OSA/3.0/api")
 * @Serializer\XmlNamespace(uri="http://schemas.nav.gov.hu/NTCA/1.0/common", prefix="common")
 * @Serializer\AccessorOrder("custom", custom={"header", "user", "software", "invoiceId", "invoiceDirection", "batchIndex", "supplierTaxNumber"})
 */
class QueryInvoiceDataRequest
{
    const PATH = 'queryInvoiceData';

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
     * @var InvoiceNumberQuery
     *
     * @Serializer\SerializedName("invoiceNumberQuery")
     * @Serializer\Type("Flexibill\NavBundle\Model\InvoiceNumberQuery")
     */
    protected $invoiceNumberQuery;

    /**
     * @return InvoiceNumberQuery
     */
    public function getInvoiceNumberQuery(): InvoiceNumberQuery
    {
        return $this->invoiceNumberQuery;
    }

    /**
     * @param InvoiceNumberQuery $invoiceNumberQuery
     *
     * @return QueryInvoiceDataRequest
     */
    public function setInvoiceNumberQuery(InvoiceNumberQuery $invoiceNumberQuery): QueryInvoiceDataRequest
    {
        $this->invoiceNumberQuery = $invoiceNumberQuery;

        return $this;
    }
}
