<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\MappedSuperclass()
 * Class NavUserData
 * @package Flexibill\NavBundle\Entity
 */
abstract class NavUserData
{
    const
        ATTR_USER_NAME = 'userName',
        ATTR_PASSWORD = 'password',
        ATTR_XML_SIGN_KEY = 'xmlSignKey',
        ATTR_XML_EXCHANGE_KEY = 'xmlExchangeKey'
    ;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $userName;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $xmlSignKey;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $xmlExchangeKey;

    /**
     * @return string
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return $this
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
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
     * @param string|null $password
     * @return $this
     */
    public function setPassword(?string $password)
    {
        $this->password = $password;
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
    public function setXmlSignKey(string $xmlSignKey)
    {
        $this->xmlSignKey = $xmlSignKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getXmlExchangeKey(): ?string
    {
        return $this->xmlExchangeKey;
    }

    /**
     * @param string $xmlExchangeKey
     * @return $this
     */
    public function setXmlExchangeKey(string $xmlExchangeKey)
    {
        $this->xmlExchangeKey = $xmlExchangeKey;
        return $this;
    }
}
