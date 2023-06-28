<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class TechnicalValidationResult
 * @package Flexibill\NavBundle\Model
 */
class TechnicalValidationResult
{
    /**
     * @var string
     */
    protected $validationResultCode;

    /**
     * @var string
     */
    protected $validationErrorCode;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return string
     */
    public function getValidationResultCode(): ?string
    {
        return $this->validationResultCode;
    }

    /**
     * @param string $validationResultCode
     * @return $this
     */
    public function setValidationResultCode(string $validationResultCode)
    {
        $this->validationResultCode = $validationResultCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidationErrorCode(): ?string
    {
        return $this->validationErrorCode;
    }

    /**
     * @param string $validationErrorCode
     * @return $this
     */
    public function setValidationErrorCode(string $validationErrorCode)
    {
        $this->validationErrorCode = $validationErrorCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }
}