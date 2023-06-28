<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use Flexibill\NavBundle\Validator\Constraints as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package Flexibill\NavBundle\Model
 *
 * @Serializer\XmlRoot("common:user")
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\AccessorOrder("custom", custom={"login", "passwordHash", "taxNumber", "requestSignature"})
 */
class User
{
    /**
     * Login name of the technical user
     * 15 chars of the length
     *
     * @var string
     *
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern="/[a-zA-Z0-9]{6,15}/",
     *     match=true,
     *     message="Technical username is not valid"
     * )
     *
     * @Serializer\SerializedName("common:login")
     * @Serializer\Expose()
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected $login;

    /**
     * Uppercase SHA-512 hash value of the technical user's password
     *
     * @var PasswordHash|null
     *
     * @Serializer\SerializedName("common:passwordHash")
     * @Serializer\Expose()
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected $passwordHash;

    /**
     * The taxpayer's tax number, whose name the technical user operates in
     *
     * @var string
     *
     * @CustomAssert\TaxNumber
     *
     * @Serializer\SerializedName("common:taxNumber")
     * @Serializer\Expose()
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected $taxNumber;

    /**
     * Uppercase SHA3-512 hash value of the request's signature
     *
     * @var RequestSignature
     *
     * @Serializer\SerializedName("common:requestSignature")
     * @Serializer\Expose()
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"short", "long", "specific"})
     */
    protected $requestSignature;

    /**
     * @var string
     * @Assert\NotNull
     */
    protected $xmlSignKey;

    /**
     * @var string
     * @Assert\NotBlank
     */
    protected $password;

    /**
     * @var string
     * @Assert\NotBlank
     */
    protected $exchangeKey;

    /**
     * @return string
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return $this
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return null|PasswordHash
     */
    public function getPasswordHash(): ?PasswordHash
    {
        if($this->password) {
            $passwordHash = new PasswordHash();
            $passwordHash->setHashValue($this->password);
        }

        return $passwordHash ?? null;
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
     * @return RequestSignature
     */
    public function getRequestSignature(): ?RequestSignature
    {
        return $this->requestSignature;
    }

    /**
     * @param string|null $requestSignatureString
     *
     * @return $this
     */
    public function setRequestSignature(?string $requestSignatureString)
    {
       if($requestSignatureString) {
            $requestSignature = new RequestSignature();
            $requestSignature->setHashValue($requestSignatureString);
            $this->requestSignature = $requestSignature;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getXmlSignKey(): ?string
    {
        return $this->xmlSignKey;
    }

    /**
     * @param string $xmlSignKey
     * @return $this
     */
    public function setXmlSignKey(?string $xmlSignKey)
    {
        $this->xmlSignKey = $xmlSignKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
        $this->passwordHash = $this->getPasswordHash();

        return $this;
    }

    /**
     * @return string
     */
    public function getExchangeKey(): ?string
    {
        return $this->exchangeKey;
    }

    /**
     * @param string $exchangeKey
     * @return $this
     */
    public function setExchangeKey(string $exchangeKey)
    {
        $this->exchangeKey = $exchangeKey;
        return $this;
    }
}
