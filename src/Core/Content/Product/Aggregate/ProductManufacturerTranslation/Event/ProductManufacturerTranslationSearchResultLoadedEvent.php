<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductManufacturerTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Product\Aggregate\ProductManufacturerTranslation\Struct\ProductManufacturerTranslationSearchResult;
use Shopware\Framework\Event\NestedEvent;

class ProductManufacturerTranslationSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'product_manufacturer_translation.search.result.loaded';

    /**
     * @var ProductManufacturerTranslationSearchResult
     */
    protected $result;

    public function __construct(ProductManufacturerTranslationSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->result->getContext();
    }
}
