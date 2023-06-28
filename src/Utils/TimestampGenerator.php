<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Utils;

use DateTime;
use DateTimeZone;

/**
 * Class TimestampGenerator
 * @package Flexibill\NavBundle\Utils
 */
class TimestampGenerator
{
    const FORMAT = 'Y-m-d\TH:i:s';
    const TIMEZONE = 'UTC';
    const USEC = 'usec';

    /**
     * @param string|null $formattedTimestamp
     *
     * @return string
     */
    public static function generate($formattedTimestamp = null): string
    {
        if (!$formattedTimestamp) {
            $formattedTimestamp = self::getUTCDateTimeWithFormat();
        }

        $milliSeconds = substr('000' . round(gettimeofday()[self::USEC] / 1000), -3);

        return $formattedTimestamp . '.' . $milliSeconds . 'Z';
    }

    /**
     * @param DateTime $dateTime
     * @param string $format
     *
     * @return string
     */
    public static function generateFromDateTime(DateTime $dateTime, $format = self::FORMAT): string
    {
        $dateTime->setTimezone(new DateTimeZone(self::TIMEZONE));

        return self::generate($dateTime->format($format));
    }

    /**
     * @param $format
     *
     * @return string
     */
    public static function getUTCDateTimeWithFormat($format = self::FORMAT): string
    {
        $timeZone = new DateTimeZone(self::TIMEZONE);
        $dateTime = new DateTime('now', $timeZone);

        return $dateTime->format($format);
    }
}
