<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Utils;

/**
 * Class SHA512Hasher
 * @package Flexibill\NavBundle\Utils
 */
class SHA512HashMaker
{
    const SHA_512 = 'sha512';
    const SHA3_512 = 'sha3-512';

    /**
     * @param string $encoded
     * @param string $hashMethod
     *
     * @return string
     */
    public static function hash(string $encoded, string $hashMethod = self::SHA_512): string
    {
        return strtoupper(hash($hashMethod, $encoded));
    }
}
