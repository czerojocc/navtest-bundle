<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class RequestSignature
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("common:requestSignature")
 */
class RequestSignature
{
    /**
     * @var string
     *
     * @Serializer\XmlAttribute()
     * @Serializer\SerializedName("cryptoType")
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected string $cryptoType = 'SHA3-512';

    /**
     * @var string
     *
     * @Serializer\XmlValue()
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected string $hashValue;

    /**
     * @return string
     */
    public function getCryptoType(): string
    {
        return $this->cryptoType;
    }

    /**
     * @param string $cryptoType
     */
    public function setCryptoType(string $cryptoType): void
    {
        $this->cryptoType = $cryptoType;
    }

    /**
     * @return string
     */
    public function getHashValue(): string
    {
        return $this->hashValue;
    }

    /**
     * @param string $hashValue
     */
    public function setHashValue(string $hashValue): void
    {
        $this->hashValue = $hashValue;
    }
}
