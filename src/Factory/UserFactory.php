<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\User;

/**
 * Class UserFactory
 * @package Flexibill\NavBundle\Factory
 */
class UserFactory
{
    /**
     * @param string $taxNumber
     * @param string $login
     * @param string $password
     * @param string $xmlSignKey
     * @param null|string $requestSignature
     * @param null|string $exchangeKey
     * @return User
     */
    public static function create(
        string $taxNumber,
        string $login,
        string $password,
        string $xmlSignKey,
        ?string $requestSignature = null,
        ?string $exchangeKey = null
    )
    {
        $user = new User();

        $user->setTaxNumber($taxNumber);
        $user->setLogin($login);
        $user->setPassword($password);
        $user->setRequestSignature($requestSignature);
        $user->setXmlSignKey($xmlSignKey);
        $user->setExchangeKey($exchangeKey);

        return $user;
    }
}