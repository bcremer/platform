<?php declare(strict_types=1);

namespace Shopware\Content\Category\Aggregate\CategoryTranslation\Struct;

use Shopware\Content\Category\Aggregate\CategoryTranslation\Collection\CategoryTranslationBasicCollection;
use Shopware\Framework\ORM\Search\SearchResultInterface;
use Shopware\Framework\ORM\Search\SearchResultTrait;

class CategoryTranslationSearchResult extends CategoryTranslationBasicCollection implements SearchResultInterface
{
    use SearchResultTrait;
}
