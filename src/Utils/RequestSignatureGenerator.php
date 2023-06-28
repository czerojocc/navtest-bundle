<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Utils;

/**
 * Class RequestSignatureGenerator
 * @package Flexibill\NavBundle\Utils
 */
class RequestSignatureGenerator
{
    /**
     * @param string $requestId
     * @param string $xmlSignKey
     * @param string|null $invoiceData
     * @return string
     * @throws \Exception
     */
    public static function generate(string $requestId, string $xmlSignKey, string $invoiceData = null)
    {
        $timestamp = TimestampGenerator::getUTCDateTimeWithFormat('YmdHis');
        $request = $requestId . $timestamp . $xmlSignKey . $invoiceData;

        return SHA512HashMaker::hash($request, SHA512HashMaker::SHA3_512);
    }
}
