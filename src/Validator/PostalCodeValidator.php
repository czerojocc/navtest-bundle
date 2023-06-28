<?php

namespace Flexibill\NavBundle\Validator;

class PostalCodeValidator
{
    const MIN_LENGTH = 3;
    const MAX_LENGTH = 10;
    const PATTERN = '/[A-Z0-9][A-Z0-9\s\-]{1,8}[A-Z0-9]/';
    const NON_INTERPRETED = '0000';

    /**
     * @param string|null $postalCode
     * @return bool
     */
    public static function validate(?string $postalCode): bool
    {
        return  $postalCode &&
                strlen($postalCode) >= self::MIN_LENGTH &&
                strlen($postalCode) <= self::MAX_LENGTH &&
                preg_match(self::PATTERN, $postalCode);
    }
}
