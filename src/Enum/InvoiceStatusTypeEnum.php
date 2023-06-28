<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Enum;

use App\AppBundle\Enum\AbstractEnum;

/**
 * Class InvoiceStatusTypeEnum
 * @package Flexibill\NavBundle\Enum
 */
class InvoiceStatusTypeEnum extends AbstractEnum
{
    const
        RECEIVED = 'RECEIVED',
        PROCESSING = 'PROCESSING',
        DONE = 'DONE',
        ABORTED = 'ABORTED',
        NOT_SENT = 'NOT_SENT',
        FAILED_TO_SEND = 'FAILED_TO_SEND',
        PENDING = 'PENDING',
        UNDER_SENDING = 'UNDER_SENDING',
        SUCCESS = 'SUCCESS',
        SAVED = 'SAVED'
    ;
}
