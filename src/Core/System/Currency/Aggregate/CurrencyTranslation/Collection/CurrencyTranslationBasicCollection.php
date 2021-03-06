<?php declare(strict_types=1);

namespace Shopware\System\Currency\Aggregate\CurrencyTranslation\Collection;

use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Currency\Aggregate\CurrencyTranslation\Struct\CurrencyTranslationBasicStruct;

class CurrencyTranslationBasicCollection extends EntityCollection
{
    /**
     * @var \Shopware\System\Currency\Aggregate\CurrencyTranslation\Struct\CurrencyTranslationBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? CurrencyTranslationBasicStruct
    {
        return parent::get($id);
    }

    public function current(): CurrencyTranslationBasicStruct
    {
        return parent::current();
    }

    public function getCurrencyIds(): array
    {
        return $this->fmap(function (CurrencyTranslationBasicStruct $currencyTranslation) {
            return $currencyTranslation->getCurrencyId();
        });
    }

    public function filterByCurrencyId(string $id): self
    {
        return $this->filter(function (CurrencyTranslationBasicStruct $currencyTranslation) use ($id) {
            return $currencyTranslation->getCurrencyId() === $id;
        });
    }

    public function getLanguageIds(): array
    {
        return $this->fmap(function (CurrencyTranslationBasicStruct $currencyTranslation) {
            return $currencyTranslation->getLanguageId();
        });
    }

    public function filterByLanguageId(string $id): self
    {
        return $this->filter(function (CurrencyTranslationBasicStruct $currencyTranslation) use ($id) {
            return $currencyTranslation->getLanguageId() === $id;
        });
    }

    protected function getExpectedClass(): string
    {
        return CurrencyTranslationBasicStruct::class;
    }
}
