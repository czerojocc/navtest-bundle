<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Billing software data
 * Class Software
 * @package Flexibill\NavBundle\Model
 */
class Software
{
    /**
     * Billing software ID
     * @var string
     */
    protected $softwareId;

    /**
     * Billing software name
     * max chars 50 length
     * @var string
     */
    protected $softwareName;

    /**
     * Billing software operation type (local program or online billing service)
     * @var string
     */
    protected $softwareOperation;

    /**
     * Billing software main version
     * max chars 15
     * @var string
     */
    protected $softwareMainVersion;

    /**
     * Name of the billing software's developer
     * String of maximum 512 characters
     * @var string
     */
    protected $softwareDevName;

    /**
     * Electronic contact of the billing software's developer
     * Working Email address
     * String of maximum 200 characters
     * @var string
     */
    protected $softwareDevContact;

    /**
     * ISO-3166 alpha2 country code of the billing software's developer
     * Country code type (ISO 3166 alpha-2)
     * @var string
     */
    protected $softwareDevCountryCode;

    /**
     * Tax number of the billing software's developer
     * @var string
     */
    protected $softwareDevTaxNumber;

    /**
     * @return string
     */
    public function getSoftwareId(): ?string
    {
        return $this->softwareId;
    }

    /**
     * @param string $softwareId
     * @return $this
     */
    public function setSoftwareId(string $softwareId)
    {
        $this->softwareId = $softwareId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareName(): ?string
    {
        return $this->softwareName;
    }

    /**
     * @param string $softwareName
     * @return $this
     */
    public function setSoftwareName(string $softwareName)
    {
        $this->softwareName = $softwareName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareOperation(): ?string
    {
        return $this->softwareOperation;
    }

    /**
     * @param string $softwareOperation
     * @return $this
     */
    public function setSoftwareOperation(string $softwareOperation)
    {
        $this->softwareOperation = $softwareOperation;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareMainVersion(): ?string
    {
        return $this->softwareMainVersion;
    }

    /**
     * @param string $softwareMainVersion
     * @return $this
     */
    public function setSoftwareMainVersion(string $softwareMainVersion)
    {
        $this->softwareMainVersion = $softwareMainVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareDevName(): ?string
    {
        return $this->softwareDevName;
    }

    /**
     * @param string $softwareDevName
     * @return $this
     */
    public function setSoftwareDevName(string $softwareDevName)
    {
        $this->softwareDevName = $softwareDevName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareDevContact(): ?string
    {
        return $this->softwareDevContact;
    }

    /**
     * @param string $softwareDevContact
     * @return $this
     */
    public function setSoftwareDevContact(string $softwareDevContact)
    {
        $this->softwareDevContact = $softwareDevContact;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareDevCountryCode(): ?string
    {
        return $this->softwareDevCountryCode;
    }

    /**
     * @param string $softwareDevCountryCode
     * @return $this
     */
    public function setSoftwareDevCountryCode(string $softwareDevCountryCode)
    {
        $this->softwareDevCountryCode = $softwareDevCountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftwareDevTaxNumber(): ?string
    {
        return $this->softwareDevTaxNumber;
    }

    /**
     * @param string $softwareDevTaxNumber
     * @return $this
     */
    public function setSoftwareDevTaxNumber(string $softwareDevTaxNumber)
    {
        $this->softwareDevTaxNumber = $softwareDevTaxNumber;
        return $this;
    }
}