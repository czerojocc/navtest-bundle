<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\ManageAnnulmentRequest;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ManageAnnulmentRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class ManageAnnulmentRequestFactory
{
    /**
     * @param User $user
     * @param Software $software
     * @param string $exchangeToken
     * @param string $requestId
     *
     * @param array $annulmentOperations
     *
     * @return ManageAnnulmentRequest
     */
    public static function create(
        User $user,
        Software $software,
        string $exchangeToken,
        string $requestId,
        array $annulmentOperations
    ): ManageAnnulmentRequest
    {
        $request = new ManageAnnulmentRequest();
        $request->setHeader(HeaderFactory::createByNamespace($requestId, HeaderFactory::NAMESPACE_COMMON));
        $request->setUser($user);
        $request->setSoftware($software);
        $request->setExchangeToken($exchangeToken);
        $request->setAnnulmentOperations(new ArrayCollection($annulmentOperations));

        return $request;
    }
}
