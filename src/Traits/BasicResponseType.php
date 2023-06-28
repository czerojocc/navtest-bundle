<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\Traits;

use Flexibill\NavBundle\Model\BasicResult;
use Flexibill\NavBundle\Model\Header;
use Flexibill\NavBundle\Model\Software;

/**
 * Trait BasicRequestType
 * @package Flexibill\NavBundle\Traits
 */
trait BasicResponseType
{
    /**
     * @var Header
     */
    protected $header;

    /**
     * @var BasicResult
     */
    protected $result;

    /**
     * @var Software
     */
    protected $software;

    /**
     * @return Header
     */
    public function getHeader(): ?Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     * @return $this
     */
    public function setHeader(Header $header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return BasicResult
     */
    public function getResult(): ?BasicResult
    {
        return $this->result;
    }

    /**
     * @param BasicResult $result
     * @return $this
     */
    public function setResult(BasicResult $result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return Software
     */
    public function getSoftware(): ?Software
    {
        return $this->software;
    }

    /**
     * @param Software $software
     * @return $this
     */
    public function setSoftware(Software $software)
    {
        $this->software = $software;
        return $this;
    }
}