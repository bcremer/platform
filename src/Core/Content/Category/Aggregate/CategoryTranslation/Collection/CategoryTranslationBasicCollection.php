<?php declare(strict_types=1);

namespace Shopware\Content\Category\Aggregate\CategoryTranslation\Collection;

use Shopware\Content\Category\Aggregate\CategoryTranslation\Struct\CategoryTranslationBasicStruct;
use Shopware\Framework\ORM\EntityCollection;

class CategoryTranslationBasicCollection extends EntityCollection
{
    /**
     * @var \Shopware\Content\Category\Aggregate\CategoryTranslation\Struct\CategoryTranslationBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? CategoryTranslationBasicStruct
    {
        return parent::get($id);
    }

    public function current(): CategoryTranslationBasicStruct
    {
        return parent::current();
    }

    public function getCategoryIds(): array
    {
        return $this->fmap(function (CategoryTranslationBasicStruct $categoryTranslation) {
            return $categoryTranslation->getCategoryId();
        });
    }

    public function filterByCategoryId(string $id): self
    {
        return $this->filter(function (CategoryTranslationBasicStruct $categoryTranslation) use ($id) {
            return $categoryTranslation->getCategoryId() === $id;
        });
    }

    public function getLanguageIds(): array
    {
        return $this->fmap(function (CategoryTranslationBasicStruct $categoryTranslation) {
            return $categoryTranslation->getLanguageId();
        });
    }

    public function filterByLanguageId(string $id): self
    {
        return $this->filter(function (CategoryTranslationBasicStruct $categoryTranslation) use ($id) {
            return $categoryTranslation->getLanguageId() === $id;
        });
    }

    protected function getExpectedClass(): string
    {
        return CategoryTranslationBasicStruct::class;
    }
}
