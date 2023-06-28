<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Model;

use Flexibill\NavBundle\Traits\BasicResponseType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class GeneralErrorResponse
 * @package Flexibill\NavBundle\Model
 */
class GeneralErrorResponse
{
    use BasicResponseType;

    /**
     * @var ArrayCollection
     */
    protected $technicalValidationMessages;

    /**
     * GeneralErrorResponse constructor.
     */
    public function __construct()
    {
        $this->technicalValidationMessages = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTechnicalValidationMessages(): ?ArrayCollection
    {
        return $this->technicalValidationMessages;
    }

    /**
     * @param ArrayCollection $technicalValidationMessages
     * @return $this
     */
    public function setTechnicalValidationMessages(ArrayCollection $technicalValidationMessages)
    {
        $this->technicalValidationMessages = $technicalValidationMessages;
        return $this;
    }

    /**
     * @return TechnicalValidationResult|null
     */
    public function getFirstMessage()
    {
        if (count($this->technicalValidationMessages)) {
            return $this->technicalValidationMessages[0];
        }

        return null;
    }

}