<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class InvoiceAnnulmentType
 * @package Flexibill\NavBundle\Model
 */
class InvoiceAnnulmentType
{
    /**
     * @var
     */
    private $annulmentReference;

    /**
     * @var
     */
    private $annulmentTimestamp;

    /**
     * @var
     */
    private $annulmentCode;

    /**
     * @var
     */
    private $annulmentReason;

    /**
     * @return mixed
     */
    public function getAnnulmentReference()
    {
        return $this->annulmentReference;
    }

    /**
     * @param mixed $annulmentReference
     * @return $this
     */
    public function setAnnulmentReference($annulmentReference)
    {
        $this->annulmentReference = $annulmentReference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnnulmentTimestamp()
    {
        return $this->annulmentTimestamp;
    }

    /**
     * @param mixed $annulmentTimestamp
     * @return $this
     */
    public function setAnnulmentTimestamp($annulmentTimestamp)
    {
        $this->annulmentTimestamp = $annulmentTimestamp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnnulmentCode()
    {
        return $this->annulmentCode;
    }

    /**
     * @param mixed $annulmentCode
     * @return $this
     */
    public function setAnnulmentCode($annulmentCode)
    {
        $this->annulmentCode = $annulmentCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnnulmentReason()
    {
        return $this->annulmentReason;
    }

    /**
     * @param mixed $annulmentReason
     * @return $this
     */
    public function setAnnulmentReason($annulmentReason)
    {
        $this->annulmentReason = $annulmentReason;
        return $this;
    }


}