<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

class InvoiceIssueDate
{
    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("dateFrom")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    protected $dateFrom;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("dateTo")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    protected $dateTo;

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTime $dateFrom
     *
     * @return InvoiceIssueDate
     */
    public function setDateFrom(DateTime $dateFrom): InvoiceIssueDate
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param DateTime $dateTo
     *
     * @return InvoiceIssueDate
     */
    public function setDateTo(DateTime $dateTo): InvoiceIssueDate
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
