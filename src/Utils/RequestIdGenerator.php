<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\Utils;

/**
 * Class RequestIdGenerator
 * @package Flexibill\NavBundle\Utils
 */
class RequestIdGenerator
{
    const INTERFACE_ID = 'FB';
    const C_RANDOMCHARSET = "ACEFGHJKLMNPQRUVWXYabcdefhijkprstuvwx0123456789";
    const C_UTC = "UTC";
    const C_YMD_HISU = 'ymdHisu';

    /**
     * @return bool|string
     * @throws \Exception
     */
    public static function generate()
    {
        $now = new \DateTime('now', new \DateTimeZone(self::C_UTC));
        $strb = self::INTERFACE_ID . $now->format(self::C_YMD_HISU);

        $randomLen = strlen(self::C_RANDOMCHARSET) - 1;

        for ($i = 0; $i < 11; $i++) {
            $strb .= substr(self::C_RANDOMCHARSET, rand(0, $randomLen), 1);
        }

        $id = substr($strb, 0, 30);

        if(!preg_match('/[+a-zA-Z0-9_]{1,30}/', $id)){
            throw new \Exception('not valid request id');
        }

        return $id;
    }
}