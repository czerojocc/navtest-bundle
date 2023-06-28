<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\HeaderInterface;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\TokenExchangeRequest;
use Flexibill\NavBundle\Model\User;

/**
 * Class TokenExchangeRequestFactory
 * @package Flexibill\NavBundle\Factory
 */
class TokenExchangeRequestFactory
{
    /**
     * @param HeaderInterface $header
     * @param User $user
     * @param Software $software
     *
     * @return TokenExchangeRequest
     */
    public static function create(HeaderInterface $header, User $user, Software $software): TokenExchangeRequest
    {
        $tokenExchangeRequest = new TokenExchangeRequest();
        $tokenExchangeRequest->setHeader($header);
        $tokenExchangeRequest->setUser($user);
        $tokenExchangeRequest->setSoftware($software);

        return $tokenExchangeRequest;
    }
}
