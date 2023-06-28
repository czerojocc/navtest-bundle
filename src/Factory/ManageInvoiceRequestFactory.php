<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\InvoiceOperationList;
use Flexibill\NavBundle\Model\ManageInvoiceRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Class ManageInvoiceRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class ManageInvoiceRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param InvoiceOperationList $operationList
     * @param string $exchangeToken
     * @param string $requestId
     *
     * @return ManageInvoiceRequest
     */
    public static function create(
        User $user,
        Software $software,
        InvoiceOperationList $operationList,
        string $exchangeToken,
        string $requestId
    ): ManageInvoiceRequest
    {
        $request = new ManageInvoiceRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setExchangeToken($exchangeToken);
        $request->setInvoiceOperations($operationList);

        return $request;
    }
}
