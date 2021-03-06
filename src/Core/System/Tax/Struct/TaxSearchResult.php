<?php declare(strict_types=1);

namespace Shopware\System\Tax\Struct;

use Shopware\Framework\ORM\Search\SearchResultInterface;
use Shopware\Framework\ORM\Search\SearchResultTrait;
use Shopware\System\Tax\Collection\TaxBasicCollection;

class TaxSearchResult extends TaxBasicCollection implements SearchResultInterface
{
    use SearchResultTrait;
}
