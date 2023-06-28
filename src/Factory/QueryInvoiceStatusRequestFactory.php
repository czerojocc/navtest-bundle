<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\QueryTransactionStatusRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Class QueryInvoiceStatusRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class QueryInvoiceStatusRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param string $requestId
     * @param string $transactionId
     * @param bool $returnOriginalRequest
     *
     * @return QueryTransactionStatusRequest
     */
    public static function create(
        User $user,
        Software $software,
        string $requestId,
        string $transactionId,
        bool $returnOriginalRequest = false
    ): QueryTransactionStatusRequest
    {
        $request = new QueryTransactionStatusRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setTransactionId($transactionId);
        $request->setReturnOriginalRequest($returnOriginalRequest);

        return $request;
    }
}
