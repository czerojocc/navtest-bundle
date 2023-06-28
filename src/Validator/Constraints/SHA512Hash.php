<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Class SHA512Hash
 * @package Flexibill\NavBundle\Validator\Constraints
 */
class SHA512Hash extends Constraint
{
    const MESSAGE = "It is not a valid SHA512 hash";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}