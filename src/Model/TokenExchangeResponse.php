<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;


use Flexibill\NavBundle\Traits\BasicResponseType;

/**
 * Class TokenExchangeResponse
 * @package Flexibill\NavBundle\Model
 */
class TokenExchangeResponse implements NAVResponseInterface
{
    use BasicResponseType;

    /**
     * The issued exchange token in AES-128 ECB encoded form
     * @var string
     */
    protected $encodedExchangeToken;

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
}