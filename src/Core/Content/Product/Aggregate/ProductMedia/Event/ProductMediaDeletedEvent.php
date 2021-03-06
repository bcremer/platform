<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductMedia\Event;

use Shopware\Content\Product\Aggregate\ProductMedia\ProductMediaDefinition;
use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;

class ProductMediaDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_media.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductMediaDefinition::class;
    }
}
