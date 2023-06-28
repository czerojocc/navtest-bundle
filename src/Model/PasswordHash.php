<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Validator\Constraints as CustomAssert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class PasswordHash
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("common:passwordHash")
 */
class PasswordHash
{
    /**
     * @var string
     *
     * @Serializer\XmlAttribute()
     * @Serializer\SerializedName("cryptoType")
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected string $cryptoType = 'SHA-512';

    /**
     * @var string
     *
     * @Serializer\XmlValue(cdata=false)
     * @Serializer\Groups({"short", "long", "specific"})
     *
     * @CustomAssert\SHA512Hash
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
