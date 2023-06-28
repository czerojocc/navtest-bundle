<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\Header;
use Flexibill\NavBundle\Model\HeaderCommon;
use Flexibill\NavBundle\Model\HeaderInterface;
use Flexibill\NavBundle\Utils\TimestampGenerator;

/**
 * Class HeaderFactory
 * @package Flexibill\NavBundle\Factory
 */
class HeaderFactory
{
    const NAMESPACE_DEFAULT = 'default';
    const NAMESPACE_COMMON = 'common';

    /**
     * @param string $requestId
     * @param string $namespace
     *
     * @return HeaderInterface|null
     */
    public static function createByNamespace(
        string $requestId,
        string $namespace = self::NAMESPACE_DEFAULT
    ): ?HeaderInterface
    {
        switch ($namespace) {
            case self::NAMESPACE_DEFAULT:
                return self::createHeader(new Header(), $requestId);
            case self::NAMESPACE_COMMON:
                return self::createHeader(new HeaderCommon(), $requestId);
        }

        return null;
    }

    /**
     * @param HeaderInterface $header
     * @param string $requestId
     *
     * @return HeaderInterface
     */
    private static function createHeader(HeaderInterface $header, string $requestId): HeaderInterface
    {
        $header->setRequestId($requestId);
        $header->setTimestamp(TimestampGenerator::generate());
        $header->setHeaderVersion(HeaderInterface::HEADER_VERSION);
        $header->setRequestVersion(HeaderInterface::REQUEST_VERSION);

        return $header;
    }
}
