<?php declare(strict_types=1);

namespace Shopware\System\Locale\Aggregate\LocaleTranslation\Collection;

use Shopware\Application\Language\Collection\LanguageBasicCollection;
use Shopware\System\Locale\Aggregate\LocaleTranslation\Struct\LocaleTranslationDetailStruct;
use Shopware\System\Locale\Collection\LocaleBasicCollection;

class LocaleTranslationDetailCollection extends LocaleTranslationBasicCollection
{
    /**
     * @var LocaleTranslationDetailStruct[]
     */
    protected $elements = [];

    public function getLocales(): LocaleBasicCollection
    {
        return new LocaleBasicCollection(
            $this->fmap(function (LocaleTranslationDetailStruct $localeTranslation) {
                return $localeTranslation->getLocale();
            })
        );
    }

    public function getLanguages(): LanguageBasicCollection
    {
        return new LanguageBasicCollection(
            $this->fmap(function (LocaleTranslationDetailStruct $localeTranslation) {
                return $localeTranslation->getLanguage();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return LocaleTranslationDetailStruct::class;
    }
}
