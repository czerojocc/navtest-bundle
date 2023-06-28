<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

/**
 * Interface NAVRequestInterface
 * @package Flexibill\NavBundle\Model
 */
interface NAVRequestInterface
{
    /**
     * @return HeaderInterface|null
     */
    public function getHeader(): ?HeaderInterface;

    /**
     * @param HeaderInterface $header
     *
     * @return mixed
     */
    public function setHeader(HeaderInterface $header);

    /**
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function setUser(User $user);

    /**
     * @return Software|null
     */
    public function getSoftware(): ?Software;

    /**
     * @param Software $software
     *
     * @return mixed
     */
    public function setSoftware(Software $software);
}
