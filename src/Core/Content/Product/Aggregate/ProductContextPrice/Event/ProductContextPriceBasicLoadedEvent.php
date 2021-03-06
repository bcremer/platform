<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductContextPrice\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Product\Aggregate\ProductContextPrice\Collection\ProductContextPriceBasicCollection;
use Shopware\Framework\Event\NestedEvent;

class ProductContextPriceBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'product_context_price.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ProductContextPriceBasicCollection
     */
    protected $productContextPrices;

    public function __construct(ProductContextPriceBasicCollection $productContextPrices, ApplicationContext $context)
    {
        $this->context = $context;
        $this->productContextPrices = $productContextPrices;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getProductContextPrices(): ProductContextPriceBasicCollection
    {
        return $this->productContextPrices;
    }
}
