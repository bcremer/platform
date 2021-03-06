<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductSearchKeyword\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Product\Aggregate\ProductSearchKeyword\Collection\ProductSearchKeywordBasicCollection;
use Shopware\Framework\Event\NestedEvent;

class ProductSearchKeywordBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'product_search_keyword.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ProductSearchKeywordBasicCollection
     */
    protected $productSearchKeywords;

    public function __construct(ProductSearchKeywordBasicCollection $productSearchKeywords, ApplicationContext $context)
    {
        $this->context = $context;
        $this->productSearchKeywords = $productSearchKeywords;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getProductSearchKeywords(): ProductSearchKeywordBasicCollection
    {
        return $this->productSearchKeywords;
    }
}
