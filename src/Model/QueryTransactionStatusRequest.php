<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicRequestType;

/**
 * Class QueryTransactionStatusRequest
 * @package Flexibill\NavBundle\Model
 */
class QueryTransactionStatusRequest
{
    const PATH = 'queryTransactionStatus';

    use BasicRequestType;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @var bool
     */
    protected $returnOriginalRequest;

    /**
     * @return string
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReturnOriginalRequest(): ?bool
    {
        return $this->returnOriginalRequest;
    }

    /**
     * @param bool $returnOriginalRequest
     * @return $this
     */
    public function setReturnOriginalRequest(bool $returnOriginalRequest)
    {
        $this->returnOriginalRequest = $returnOriginalRequest;
        return $this;
    }
}
