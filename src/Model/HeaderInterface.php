<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use DateTime;

/**
 * Interface HeaderInterface
 * @package Flexibill\NavBundle\Model
 */
interface HeaderInterface
{
    const REQUEST_VERSION = '3.0';
    const HEADER_VERSION = '1.0';

    /**
     * @return string
     */
    public function getRequestId(): ?string;

    /**
     * @param string $requestId
     *
     * @return $this
     */
    public function setRequestId(string $requestId);

    /**
     * @return DateTime
     */
    public function getTimestamp(): ?string;

    /**
     * @param string $timestamp
     *
     * @return $this
     */
    public function setTimestamp(string $timestamp);

    /**
     * @return string
     */
    public function getRequestVersion(): ?string;

    /**
     * @param string $requestVersion
     *
     * @return $this
     */
    public function setRequestVersion(string $requestVersion);

    /**
     * @return string
     */
    public function getHeaderVersion(): ?string;

    /**
     * @param string $headerVersion
     *
     * @return $this
     */
    public function setHeaderVersion(string $headerVersion);
}
