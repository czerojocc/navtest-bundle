<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class InsDate
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("dateTimeFrom")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $dateTimeFrom;

    /**
     * @var string
     *
     * @Serializer\SerializedName("dateTimeTo")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $dateTimeTo;

    /**
     * @return string
     */
    public function getDateTimeFrom(): string
    {
        return $this->dateTimeFrom;
    }

    /**
     * @param string $dateTimeFrom
     *
     * @return InsDate
     */
    public function setDateTimeFrom(string $dateTimeFrom): InsDate
    {
        $this->dateTimeFrom = $dateTimeFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateTimeTo(): string
    {
        return $this->dateTimeTo;
    }

    /**
     * @param string $dateTimeTo
     *
     * @return InsDate
     */
    public function setDateTimeTo(string $dateTimeTo): InsDate
    {
        $this->dateTimeTo = $dateTimeTo;

        return $this;
    }
}
