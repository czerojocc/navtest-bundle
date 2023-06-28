<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaxpayerAddress
 * @package Flexibill\NavBundle\Model
 */
class TaxpayerAddress
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("countryCode")
     * @Serializer\Type("string")
     */
    protected $countryCode;

    /**
     * @var string
     *
     * @Serializer\SerializedName("postalCode")
     * @Serializer\Type("string")
     */
    protected $postalCode;

    /**
     * @var string
     *
     * @Serializer\SerializedName("city")
     * @Serializer\Type("string")
     */
    protected $city;

    /**
     * @var string
     *
     * @Serializer\SerializedName("streetName")
     * @Serializer\Type("string")
     */
    protected $streetName;

    /**
     * @var string
     *
     * @Serializer\SerializedName("publicPlaceCategory")
     * @Serializer\Type("string")
     */
    protected $publicPlaceCategory;

    /**
     * @var string
     *
     * @Serializer\SerializedName("number")
     * @Serializer\Type("string")
     */
    protected $number;

    /**
     * @var string
     *
     * @Serializer\SerializedName("staircase")
     * @Serializer\Type("string")
     */
    protected $staircase;

    /**
     * @var string
     *
     * @Serializer\SerializedName("floor")
     * @Serializer\Type("string")
     */
    protected $floor;

    /**
     * @var string
     *
     * @Serializer\SerializedName("door")
     * @Serializer\Type("string")
     */
    protected $door;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     */
    public function setStreetName(string $streetName): void
    {
        $this->streetName = $streetName;
    }

    /**
     * @return string
     */
    public function getPublicPlaceCategory(): string
    {
        return $this->publicPlaceCategory;
    }

    /**
     * @param string $publicPlaceCategory
     */
    public function setPublicPlaceCategory(string $publicPlaceCategory): void
    {
        $this->publicPlaceCategory = $publicPlaceCategory;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getStaircase(): string
    {
        return $this->staircase;
    }

    /**
     * @param string $staircase
     */
    public function setStaircase(string $staircase): void
    {
        $this->staircase = $staircase;
    }

    /**
     * @return string
     */
    public function getFloor(): string
    {
        return $this->floor;
    }

    /**
     * @param string $floor
     */
    public function setFloor(string $floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @return string
     */
    public function getDoor(): string
    {
        return $this->door;
    }

    /**
     * @param string $door
     */
    public function setDoor(string $door): void
    {
        $this->door = $door;
    }
}
