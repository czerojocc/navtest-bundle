<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class TechnicalValidationMessages
 * @package Flexibill\NavBundle\Model
 */
class TechnicalValidationMessages
{

    private $validationResultCode;

    private $validationErrorCode;

    private $message;

    /**
     * @return mixed
     */
    public function getValidationResultCode()
    {
        return $this->validationResultCode;
    }

    /**
     * @param mixed $validationResultCode
     * @return $this
     */
    public function setValidationResultCode($validationResultCode)
    {
        $this->validationResultCode = $validationResultCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationErrorCode()
    {
        return $this->validationErrorCode;
    }

    /**
     * @param mixed $validationErrorCode
     * @return $this
     */
    public function setValidationErrorCode($validationErrorCode)
    {
        $this->validationErrorCode = $validationErrorCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


}