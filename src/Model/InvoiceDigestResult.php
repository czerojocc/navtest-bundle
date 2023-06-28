<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class InvoiceDigestResult
{
    /**
     * @var int
     *
     * @Serializer\SerializedName("currentPage")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("integer")
     */
    protected $currentPage;

    /**
     * @var int
     *
     * @Serializer\SerializedName("availablePage")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("integer")
     */
    protected $availablePage;

    /**
     * @var InvoiceDigest[]|array
     *
     * @Serializer\XmlList(inline=true, entry="invoiceDigest")
     * @Serializer\Type("array<Flexibill\NavBundle\Model\InvoiceDigest>")
     */
    protected $invoiceDigests;

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     *
     * @return InvoiceDigestResult
     */
    public function setCurrentPage(int $currentPage): InvoiceDigestResult
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getAvailablePage(): int
    {
        return $this->availablePage;
    }

    /**
     * @param int $availablePage
     *
     * @return InvoiceDigestResult
     */
    public function setAvailablePage(int $availablePage): InvoiceDigestResult
    {
        $this->availablePage = $availablePage;

        return $this;
    }

    /**
     * @return InvoiceDigest[]|array
     */
    public function getInvoiceDigests()
    {
        return $this->invoiceDigests;
    }

    /**
     * @param InvoiceDigest[]|array $invoiceDigests
     *
     * @return InvoiceDigestResult
     */
    public function setInvoiceDigests($invoiceDigests)
    {
        $this->invoiceDigests = $invoiceDigests;

        return $this;
    }
}
