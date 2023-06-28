<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Factory;

use Flexibill\NavBundle\Model\Software;

/**
 * Class SoftwareFactory
 * @package Flexibill\NavBundle\Factory
 */
class SoftwareFactory
{
    /**
     * @param null|string $softwareId
     * @param null|string $softwareName
     * @param null|string $operation
     * @param null|string $mainVersion
     * @param null|string $developerName
     * @param null|string $developerContact
     * @param null|string $developerCountryCode
     * @param null|string $developerTaxNumber
     * @return Software
     */
    public static function create(
        ?string $softwareId,
        ?string $softwareName,
        ?string $operation,
        ?string $mainVersion,
        ?string $developerName,
        ?string $developerContact,
        ?string $developerCountryCode,
        ?string $developerTaxNumber
    )
    {
        $software = new Software();
        $software->setSoftwareId($softwareId);
        $software->setSoftwareName($softwareName);
        $software->setSoftwareOperation($operation);
        $software->setSoftwareMainVersion($mainVersion);
        $software->setSoftwareDevName($developerName);
        $software->setSoftwareDevContact($developerContact);
        $software->setSoftwareDevCountryCode($developerCountryCode);
        $software->setSoftwareDevTaxNumber($developerTaxNumber);

        return $software;
    }
}