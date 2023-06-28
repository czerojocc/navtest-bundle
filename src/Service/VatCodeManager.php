<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

use Flexibill\NavBundle\Enum\VatCodeNavCaseEnum;

class VatCodeManager
{
    const VAT_CODES = [
        'Általános adókulcsok' => [
            [
                'value' => 18,
                'name' => '18%',
                'navCase' => null,
            ],
            [
                'value' => 27,
                'name' => '27%',
                'navCase' => null,
            ],
            [
                'value' => 5,
                'name' => '5%',
                'navCase' => null,
            ]
        ],
        '0% áfakulcsok' => [
            [
                'value' => 0,
                'name' => 'AAM - Alanyi adómentes',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_AAM,
            ],
            [
                'value' => 0,
                'name' => 'FAD - fordított adózás',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_FAD,
            ],
            [
                'value' => 0,
                'name' => 'TAM - tárgyi adómentes',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_TAM,
            ],
            [
                'value' => 0,
                'name' => 'EAM - egyéb nemzetközi ügylet',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_EAM,
            ],
            [
                'value' => 0,
                'name' => 'KBAET - közösségen belüli adómentes értékesítés',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_KBAET,
            ],
            [
                'value' => 0,
                'name' => 'KBAUK - adómentes, közösségen belüli új közlekedési eszköz értékesítés',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_KBAUK,
            ],
            [
                'value' => 0,
                'name' => 'NAM - egyéb nemzetközi ügylethez kapcsoldó jogcímen mentes ügylet',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_NAM,
            ],
        ],
        'Hatályon kívűliség' => [
            [
                'value' => 0,
                'name' => 'ATK - tárgyi hatályon kívüli (például kártértés)',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_ATK,
            ],
            [
                'value' => 0,
                'name' => 'EUFAD37 - közösségi adóalanynak nyújtott, az áfatörvény 37. paragrafusa alapján (főszabály) szerint, a megrendelő gazdasági letelepedettsége országában teljesített szolgáltatás',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_EUFAD37,
            ],
            [
                'value' => 0,
                'name' => 'EUFADE - közösségi adóalanynak nyújtott, nem főszabály szerint, fordítottan adózó szolgáltatás',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_EUFADE,
            ],
            [
                'value' => 0,
                'name' => 'EUE - más tagállami, nem fordított adózású ügylet',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_EUE,
            ],
            [
                'value' => 0,
                'name' => 'HO - harmadik országban teljesített ügylet',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_HO,
            ]
        ],
        'Különbözet szerinti szabályozás' => [
            [
                'value' => 0,
                'name' => 'utazási irodák',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_TRAVEL_AGENCY,
            ],
            [
                'value' => 0,
                'name' => 'használt cikkek',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_SECOND_HAND,
            ],
            [
                'value' => 0,
                'name' => 'műalkotások',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_ARTWORK,
            ],
            [
                'value' => 0,
                'name' => 'gyűjteménydarabok és régiségek',
                'navCase' => VatCodeNavCaseEnum::VAT_CODE_ANTIQUES,
            ],
        ]
    ];

    /**
     * @return array
     */
    public static function getVatCodesWithoutGroups(): array
    {
        $vatCodes = [];

        foreach (self::VAT_CODES as $groupVatCodes) {
            $vatCodes = array_merge($vatCodes, $groupVatCodes);
        }

        return $vatCodes;
    }

    /**
     * @return array
     */
    public static function getAvailableNavCases(): array
    {
        $navCases = [];

        foreach (self::getVatCodesWithoutGroups() as $vatCodes) {
            $navCases[] = $vatCodes['navCase'];
        }

        return $navCases;
    }

    /**
     * @return array
     */
    public static function getAvailableTaxOptions(): array
    {
        $vatCodes = self::getVatCodesWithoutGroups();

        $navCases = array_unique(array_column($vatCodes, 'navCase'));
        $vatNamesAboveZero = array_column(array_filter(self::getVatCodesWithoutGroups(), function($elem) {
            return $elem['value'] !== 0;
        }), 'name');

        return array_filter(array_merge($navCases, $vatNamesAboveZero), function ($elem) {
            return !is_null($elem);
        });
    }
}
