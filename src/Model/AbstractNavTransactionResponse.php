<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

abstract class AbstractNavTransactionResponse implements NAVResponseInterface
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("transactionId")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Type("string")
     */
    protected $transactionId;

    /**
     * @return string
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return AbstractNavTransactionResponse
     */
    public function setTransactionId(?string $transactionId): AbstractNavTransactionResponse
    {
        $this->transactionId = $transactionId;

        return $this;
    }
}
