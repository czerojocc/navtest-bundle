<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use DateTime;

/**
 * Trait HeaderTrait
 * @package Flexibill\NavBundle\Model
 */
trait HeaderTrait
{
    /**
     * Identifier of the request/response, unique with the taxnumber in every data exchange transaction
     *
     * @var string
     */
    protected $requestId;

    /**
     * UTC time of the request/response
     *
     * @var string
     */
    protected $timestamp;

    /**
     * Request version number, indicating which datastructure the client sends data in, and in which the response is expected
     *
     * @var string
     */
    protected $requestVersion;

    /**
     * Header version number
     *
     * @var string
     */
    protected $headerVersion;

    /**
     * @return string
     */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * @param string $requestId
     *
     * @return $this
     */
    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     *
     * @return $this
     */
    public function setTimestamp(string $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestVersion(): ?string
    {
        return $this->requestVersion;
    }

    /**
     * @param string $requestVersion
     *
     * @return $this
     */
    public function setRequestVersion(string $requestVersion)
    {
        $this->requestVersion = $requestVersion;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaderVersion(): ?string
    {
        return $this->headerVersion;
    }

    /**
     * @param string $headerVersion
     *
     * @return $this
     */
    public function setHeaderVersion(string $headerVersion)
    {
        $this->headerVersion = $headerVersion;

        return $this;
    }
}
