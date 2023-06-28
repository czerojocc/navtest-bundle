<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicResponseType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class QueryInvoiceStatusResponse
 * @package Flexibill\NavBundle\Model
 */
class QueryInvoiceStatusResponse
{
    use BasicResponseType;

    /**
     * @var ArrayCollection
     */
    protected $processingResults;

    /**
     * @return ArrayCollection
     */
    public function getProcessingResults()
    {
        return $this->processingResults;
    }

    /**
     * @param ArrayCollection $processingResults
     * @return $this
     */
    public function setProcessingResults($processingResults)
    {
        $this->processingResults = $processingResults;
        return $this;
    }
}