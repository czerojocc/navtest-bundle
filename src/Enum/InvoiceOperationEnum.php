<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Enum;

use App\AppBundle\Enum\AbstractEnum;


/**
 * Class InvoiceOperation
 * @package Flexibill\NavBundle\Enum
 */
class InvoiceOperationEnum extends AbstractEnum
{
    const
        CREATE = 'CREATE',
        MODIFY = 'MODIFY',
        STORNO = 'STORNO',
        ANNUL = 'ANNUL'
    ;
}