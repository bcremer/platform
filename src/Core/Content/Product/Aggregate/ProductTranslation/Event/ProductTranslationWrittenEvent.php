<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductTranslation\Event;

use Shopware\Content\Product\Aggregate\ProductTranslation\ProductTranslationDefinition;
use Shopware\Framework\ORM\Write\WrittenEvent;

class ProductTranslationWrittenEvent extends WrittenEvent
{
    public const NAME = 'product_translation.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductTranslationDefinition::class;
    }
}
