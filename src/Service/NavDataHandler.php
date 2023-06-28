<?php

namespace Flexibill\NavBundle\Service;

use App\AppBundle\Exception\HttpException;
use App\CompanyBundle\Entity\Company;
use Flexibill\NavBundle\Entity\NavUserData;
use Symfony\Contracts\Translation\TranslatorInterface;


class NavDataHandler
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function validate(?NavUserData $navData)
    {
        if (is_null($navData)
            || !$navData->getUserName()
            || !$navData->getPassword()
            || !$navData->getXmlSignKey()
            || !$navData->getXmlExchangeKey()
        ) {
            throw new HttpException($this->translator->trans('nav_data.empty'));
        }
    }
}
