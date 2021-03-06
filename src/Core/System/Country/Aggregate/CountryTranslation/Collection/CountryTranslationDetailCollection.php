<?php declare(strict_types=1);

namespace Shopware\System\Country\Aggregate\CountryTranslation\Collection;

use Shopware\Application\Language\Collection\LanguageBasicCollection;
use Shopware\System\Country\Aggregate\CountryTranslation\Struct\CountryTranslationDetailStruct;
use Shopware\System\Country\Collection\CountryBasicCollection;

class CountryTranslationDetailCollection extends CountryTranslationBasicCollection
{
    /**
     * @var \Shopware\System\Country\Aggregate\CountryTranslation\Struct\CountryTranslationDetailStruct[]
     */
    protected $elements = [];

    public function getCountries(): CountryBasicCollection
    {
        return new CountryBasicCollection(
            $this->fmap(function (CountryTranslationDetailStruct $countryTranslation) {
                return $countryTranslation->getCountry();
            })
        );
    }

    public function getLanguages(): LanguageBasicCollection
    {
        return new LanguageBasicCollection(
            $this->fmap(function (CountryTranslationDetailStruct $countryTranslation) {
                return $countryTranslation->getLanguage();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return CountryTranslationDetailStruct::class;
    }
}
