<?php declare(strict_types=1);

namespace Shopware\Application\Language\Struct;

use Shopware\Application\Language\Collection\LanguageBasicCollection;
use Shopware\Framework\ORM\Search\SearchResultInterface;
use Shopware\Framework\ORM\Search\SearchResultTrait;

class LanguageSearchResult extends LanguageBasicCollection implements SearchResultInterface
{
    use SearchResultTrait;
}
