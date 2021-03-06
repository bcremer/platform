<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductDatasheet\Event;

use Shopware\Content\Product\Aggregate\ProductDatasheet\ProductDatasheetDefinition;
use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;

class ProductDatasheetDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_datasheet.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductDatasheetDefinition::class;
    }
}
