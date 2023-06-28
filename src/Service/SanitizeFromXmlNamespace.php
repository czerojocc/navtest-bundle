<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

class SanitizeFromXmlNamespace
{
    /**
     * Nav can't guarantee that namespaces are in same order every time :(
     *
     * @param string $requestBody
     *
     * @return string
     */
    public static function sanitize(string $requestBody): string
    {
        $responseWithoutNamespaces = str_replace('ns1:', '', $requestBody);
        $responseWithoutNamespaces = str_replace('ns2:', '', $responseWithoutNamespaces);
        $responseWithoutNamespaces = str_replace('ns3:', '', $responseWithoutNamespaces);
        $responseWithoutNamespaces = str_replace('ns4:', '', $responseWithoutNamespaces);
        $responseWithoutNamespaces = preg_replace('/ xmlns[^=]*="[^"]*"/i', '', $responseWithoutNamespaces);

        return $responseWithoutNamespaces;
    }
}
