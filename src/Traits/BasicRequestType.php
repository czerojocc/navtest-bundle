<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Traits;

use Flexibill\NavBundle\Model\HeaderInterface;
use Flexibill\NavBundle\Model\Software;
use Flexibill\NavBundle\Model\User;

/**
 * Trait BasicRequestType
 * @package Flexibill\NavBundle\Traits
 */
trait BasicRequestType
{
    /**
     * @var HeaderInterface
     */
    protected $header;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Software
     */
    protected $software;

    /**
     * @return HeaderInterface
     */
    public function getHeader(): ?HeaderInterface
    {
        return $this->header;
    }

    /**
     * @param HeaderInterface $header
     *
     * @return $this
     */
    public function setHeader(HeaderInterface $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

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
     *
     * @return $this
     */
    public function setSoftware(Software $software)
    {
        $this->software = $software;

        return $this;
    }
}
