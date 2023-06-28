<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\QueryTaxpayerRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

class QueryTaxPayerRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param string $requestId
     * @param string $taxNumber
     *
     * @return QueryTaxpayerRequest
     */
    public static function create(
        User $user,
        Software $software,
        string $requestId,
        string $taxNumber
    ): QueryTaxpayerRequest
    {
        $request = new QueryTaxpayerRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setTaxNumber($taxNumber);

        return $request;
    }
}
