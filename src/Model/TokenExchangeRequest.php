<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;

/**
 * Class TokenExchangeRequest
 * @package Flexibill\NavBundle\Model
 */
class TokenExchangeRequest implements NAVRequestInterface
{
    const PATH = 'tokenExchange';

    use BasicRequestType;
}
