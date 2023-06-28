<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

/**
 * Interface NAVResponseInterface
 * @package Flexibill\NavBundle\Model
 */
interface NAVResponseInterface
{
    /**
     * @return Header|null
     */
    public function getHeader(): ?Header;

    /**
     * @param Header $header
     * @return mixed
     */
    public function setHeader(Header $header);

    /**
     * @return BasicResult|null
     */
    public function getResult(): ?BasicResult;

    /**
     * @param BasicResult $result
     * @return mixed
     */
    public function setResult(BasicResult $result);

    /**
     * @return Software|null
     */
    public function getSoftware(): ?Software;

    /**
     * @param Software $software
     * @return mixed
     */
    public function setSoftware(Software $software);
}