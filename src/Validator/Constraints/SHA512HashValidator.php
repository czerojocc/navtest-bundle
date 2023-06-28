<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class SHA512HashValidator
 * @package Flexibill\NavBundle\Validator\Constraints
 */
class SHA512HashValidator extends ConstraintValidator
{
    /**
     * @var string
     */
    protected $pattern = '/[0-9A-F]{128}/';

    /**q
     * @param string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->haveToValidate($value)) {
            return;
        }

        if (!$this->isValidType($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $isValid = $this->check($value);

        if (!$isValid) {
            $this->context->buildViolation(SHA512Hash::MESSAGE)
                ->addViolation();
        }
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function haveToValidate($value)
    {
        return ($value !== null && $value !== '');
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function isValidType($value)
    {
        return (
            is_scalar($value) || (is_object($value) && method_exists($value, '__toString'))
        );
    }

    /**
     * @param string $value
     * @return boolean
     */
    protected function check($value)
    {
        return preg_match($this->pattern, $value);
    }
}