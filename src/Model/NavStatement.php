<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class NavStatement
 * @package Flexibill\NavBundle\Model
 *
 * @deprecated Remove when currently active but deprecated endpoint(s) which use this are removed
 */
class NavStatement
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $taxNumber;

    /**
     * @var string
     */
    private $addressLine;

    /**
     * @var string
     */
    private $date;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     * @return $this
     */
    public function setTaxNumber(string $taxNumber)
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine(): ?string
    {
        return $this->addressLine;
    }

    /**
     * @param string $addressLine
     * @return $this
     */
    public function setAddressLine(string $addressLine)
    {
        $this->addressLine = $addressLine;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }
}