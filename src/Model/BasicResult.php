<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

/**
 * Class BasicResult
 * @package Flexibill\NavBundle\Model
 */
class BasicResult
{
    /**
     * @var string
     */
    protected $funcCode;

    /**
     * @var string
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $message;

    /**
     * @return string
     */
    public function getFuncCode(): ?string
    {
        return $this->funcCode;
    }

    /**
     * @param string $funcCode
     * @return $this
     */
    public function setFuncCode(string $funcCode)
    {
        $this->funcCode = $funcCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param string $errorCode
     * @return $this
     */
    public function setErrorCode(string $errorCode)
    {
        $this->errorCode = $errorCode;
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