<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

use Flexibill\NavBundle\Exception\InvalidRequestException;
use Flexibill\NavBundle\Exception\InvalidTokenExchangeRequestException;
use Flexibill\NavBundle\Model\TokenExchange;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Interface TokenExchangeManagerInterface
 * @package Flexibill\NavBundle\Service
 */
interface TokenExchangeManagerInterface
{
    /**
     * @param User $user
     * @param Software $software
     * @return TokenExchange
     * @throws InvalidRequestException
     * @throws InvalidTokenExchangeRequestException
     * @throws \Flexibill\NavBundle\Exception\NotEnabledModuleException
     * @throws \Exception
     */
    public function getToken(User $user, Software $software): TokenExchange;

    public function getExpiryDateTime();
}