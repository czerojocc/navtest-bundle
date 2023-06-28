<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\InvoiceQueryDigestParams;
use Flexibill\NavBundle\Model\QueryInvoiceDigestRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Class QueryInvoiceDigestRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class QueryInvoiceDigestRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param InvoiceQueryDigestParams $invoiceQueryParams
     * @param string $direction
     * @param string $requestId
     * @param int $page
     *
     * @return QueryInvoiceDigestRequest
     */
    public static function create(
        User $user,
        Software $software,
        InvoiceQueryDigestParams $invoiceQueryParams,
        string $direction,
        string $requestId,
        int $page
    ): QueryInvoiceDigestRequest
    {
        $request = new QueryInvoiceDigestRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setInvoiceDirection($direction);
        $request->setInvoiceQueryParams($invoiceQueryParams);
        $request->setPage($page);

        return $request;
    }
}
