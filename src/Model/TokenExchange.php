<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class TokenExchange
 * @package Flexibill\NavBundle\Model
 */
class TokenExchange
{
    /**
     * Validity start of the issued exchange token
     * @var \DateTime
     */
    protected $tokenValidityFrom;

    /**
     * Validity end of the issued exchange token
     * @var \DateTime
     */
    protected $tokenValidityTo;

    /**
     * The issued exchange token in AES-128 ECB encoded form
     * @var string
     */
    protected $encodedExchangeToken;

    /**
     * @return \DateTime
     */
    public function getTokenValidityFrom(): ?\DateTime
    {
        return $this->tokenValidityFrom;
    }

    /**
     * @param \DateTime $tokenValidityFrom
     * @return $this
     */
    public function setTokenValidityFrom(\DateTime $tokenValidityFrom)
    {
        $this->tokenValidityFrom = $tokenValidityFrom;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTokenValidityTo(): ?\DateTime
    {
        return $this->tokenValidityTo;
    }

    /**
     * @param \DateTime $tokenValidityTo
     * @return $this
     */
    public function setTokenValidityTo(\DateTime $tokenValidityTo)
    {
        $this->tokenValidityTo = $tokenValidityTo;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncodedExchangeToken(): ?string
    {
        return $this->encodedExchangeToken;
    }

    /**
     * @param string $encodedExchangeToken
     * @return $this
     */
    public function setEncodedExchangeToken(string $encodedExchangeToken)
    {
        $this->encodedExchangeToken = $encodedExchangeToken;
        return $this;
    }

    /**
     * @param $exchangeKey
     * @return string
     */
    public function getDecodedExchangeToken($exchangeKey)
    {
        return openssl_decrypt($this->encodedExchangeToken, 'AES-128-ECB', $exchangeKey);
    }
}