<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class MandatoryQueryParams
{
    /**
     * @var InvoiceIssueDate
     *
     * @Serializer\SerializedName("invoiceIssueDate")
     */
    protected $invoiceIssueDate;

    /**
     * @var InsDate
     *
     * @Serializer\SerializedName("insDate")
     */
    protected $insDate;

    /**
     * @var string
     *
     * @Serializer\SerializedName("originalInvoiceNumber")
     */
    protected $originalInvoiceNumber;

    /**
     * @return InvoiceIssueDate
     */
    public function getInvoiceIssueDate(): InvoiceIssueDate
    {
        return $this->invoiceIssueDate;
    }

    /**
     * @param InvoiceIssueDate $invoiceIssueDate
     *
     * @return MandatoryQueryParams
     */
    public function setInvoiceIssueDate(InvoiceIssueDate $invoiceIssueDate): MandatoryQueryParams
    {
        $this->invoiceIssueDate = $invoiceIssueDate;

        return $this;
    }

    /**
     * @return InsDate
     */
    public function getInsDate(): InsDate
    {
        return $this->insDate;
    }

    /**
     * @param InsDate $insDate
     *
     * @return MandatoryQueryParams
     */
    public function setInsDate(InsDate $insDate): MandatoryQueryParams
    {
        $this->insDate = $insDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalInvoiceNumber(): string
    {
        return $this->originalInvoiceNumber;
    }

    /**
     * @param string $originalInvoiceNumber
     *
     * @return MandatoryQueryParams
     */
    public function setOriginalInvoiceNumber(string $originalInvoiceNumber): MandatoryQueryParams
    {
        $this->originalInvoiceNumber = $originalInvoiceNumber;

        return $this;
    }
}
