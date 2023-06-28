<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * Class TaxNumber
 * @package Flexibill\NavBundle\Validator\Constraints
 */
class TaxNumber extends Constraint
{
    const MESSAGE = "It is not a valid tax number";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}