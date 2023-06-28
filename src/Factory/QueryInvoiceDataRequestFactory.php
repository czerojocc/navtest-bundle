<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\InvoiceNumberQuery;
use Flexibill\NavBundle\Model\QueryInvoiceDataRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Class QueryInvoiceDataRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class QueryInvoiceDataRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param string $requestId
     * @param string $invoiceId
     * @param string $invoiceDirection
     * @param string $supplierTaxNumber
     *
     * @return QueryInvoiceDataRequest
     */
    public static function create(
        User $user,
        Software $software,
        string $requestId,
        string $invoiceId,
        string $invoiceDirection,
        string $supplierTaxNumber
    ): QueryInvoiceDataRequest
    {
        $invoiceNumberQuery = new InvoiceNumberQuery();
        $invoiceNumberQuery->setInvoiceNumber($invoiceId);
        $invoiceNumberQuery->setInvoiceDirection($invoiceDirection);

        if ($invoiceDirection !== QueryInvoiceDataRequest::DIRECTION_OUTBOUND) {
            $invoiceNumberQuery->setSupplierTaxNumber($supplierTaxNumber);
        }

        $request = new QueryInvoiceDataRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setInvoiceNumberQuery($invoiceNumberQuery);

        return $request;
    }
}
