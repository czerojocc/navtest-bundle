<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Enum;

use App\AppBundle\Enum\AbstractEnum;

/**
 * Class StatusEnum
 * @package Flexibill\NavBundle\Enum
 */
class StatusEnum extends AbstractEnum
{
    const
        NOT_SENT = 'NOT_SENT',
        SUCCESS = 'SUCCESS',
        PENDING = 'PENDING',
        FAILED = 'FAILED',
        SENT = 'SENT',
        INCOMING = 'INCOMING'
    ;
}
