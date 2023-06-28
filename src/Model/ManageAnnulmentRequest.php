<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class ManageAnnulmentRequest
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("ManageAnnulmentRequest")
 * @Serializer\XmlNamespace("http://schemas.nav.gov.hu/OSA/3.0/api")
 * @Serializer\XmlNamespace(uri="http://schemas.nav.gov.hu/NTCA/1.0/common", prefix="common")
 * @Serializer\AccessorOrder("custom", custom={"header", "user", "software", "exchangeToken", "annulmentOperations"})
 */
class ManageAnnulmentRequest implements NAVRequestInterface
{
    const PATH = 'manageAnnulment';

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
     * @var string
     *
     * @Serializer\SerializedName("exchangeToken")
     * @Serializer\XmlElement(cdata=false)
     */
    protected $exchangeToken;

    /**
     * @var AnnulmentOperation[]|ArrayCollection|Collection
     *
     * @Serializer\SerializedName("annulmentOperations")
     * @Serializer\XmlList(entry="annulmentOperation")
     */
    protected $annulmentOperations;

    public function __construct()
    {
        $this->annulmentOperations = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getExchangeToken(): string
    {
        return $this->exchangeToken;
    }

    /**
     * @param string $exchangeToken
     *
     * @return ManageAnnulmentRequest
     */
    public function setExchangeToken(string $exchangeToken): ManageAnnulmentRequest
    {
        $this->exchangeToken = $exchangeToken;

        return $this;
    }

    /**
     * @return AnnulmentOperation[]|ArrayCollection|Collection
     */
    public function getAnnulmentOperations(): Collection
    {
        return $this->annulmentOperations;
    }

    /**
     * @param AnnulmentOperation[]|ArrayCollection|Collection $annulmentOperations
     *
     * @return ManageAnnulmentRequest
     */
    public function setAnnulmentOperations(Collection $annulmentOperations)
    {
        $this->annulmentOperations = $annulmentOperations;

        return $this;
    }
}
