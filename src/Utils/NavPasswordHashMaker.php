<?php

namespace Flexibill\NavBundle\Utils;

class NavPasswordHashMaker
{
    /**
     * @param string $plainPassword
     * @return string
     */
    public static function hash(string $plainPassword): string
    {
        return SHA512HashMaker::hash($plainPassword);
    }
}
