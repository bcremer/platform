<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductStreamTab;

use Shopware\Content\Product\Aggregate\ProductStream\ProductStreamDefinition;
use Shopware\Content\Product\Aggregate\ProductStreamTab\Event\ProductStreamTabDeletedEvent;
use Shopware\Content\Product\Aggregate\ProductStreamTab\Event\ProductStreamTabWrittenEvent;
use Shopware\Content\Product\ProductDefinition;
use Shopware\Framework\ORM\Field\DateField;
use Shopware\Framework\ORM\Field\FkField;
use Shopware\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Framework\ORM\Field\ReferenceVersionField;
use Shopware\Framework\ORM\FieldCollection;
use Shopware\Framework\ORM\MappingEntityDefinition;
use Shopware\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Framework\ORM\Write\Flag\Required;

class ProductStreamTabDefinition extends MappingEntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    public static function getEntityName(): string
    {
        return 'product_stream_tab';
    }

    public static function isVersionAware(): bool
    {
        return true;
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        return self::$fields = new FieldCollection([
            (new FkField('product_stream_id', 'productStreamId', ProductStreamDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(ProductStreamDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new FkField('product_id', 'productId', ProductDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(ProductDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            new ManyToOneAssociationField('productStream', 'product_stream_id', ProductStreamDefinition::class, false),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, false),
        ]);
    }

    public static function getWrittenEventClass(): string
    {
        return ProductStreamTabWrittenEvent::class;
    }

    public static function getDeletedEventClass(): string
    {
        return ProductStreamTabDeletedEvent::class;
    }
}
