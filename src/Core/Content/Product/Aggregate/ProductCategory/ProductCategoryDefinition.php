<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductCategory;

use Shopware\Content\Category\CategoryDefinition;
use Shopware\Content\Product\Aggregate\ProductCategory\Event\ProductCategoryDeletedEvent;
use Shopware\Content\Product\Aggregate\ProductCategory\Event\ProductCategoryWrittenEvent;
use Shopware\Content\Product\ProductDefinition;
use Shopware\Framework\ORM\Field\DateField;
use Shopware\Framework\ORM\Field\FkField;
use Shopware\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Framework\ORM\Field\ReferenceVersionField;
use Shopware\Framework\ORM\FieldCollection;
use Shopware\Framework\ORM\MappingEntityDefinition;
use Shopware\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Framework\ORM\Write\Flag\Required;

class ProductCategoryDefinition extends MappingEntityDefinition
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
        return 'product_category';
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
            (new FkField('product_id', 'productId', ProductDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(ProductDefinition::class))->setFlags(new PrimaryKey(), new Required()),

            (new FkField('category_id', 'categoryId', CategoryDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(CategoryDefinition::class))->setFlags(new PrimaryKey(), new Required()),

            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, false),
            new ManyToOneAssociationField('category', 'category_id', CategoryDefinition::class, false),
        ]);
    }

    public static function getWrittenEventClass(): string
    {
        return ProductCategoryWrittenEvent::class;
    }

    public static function getDeletedEventClass(): string
    {
        return ProductCategoryDeletedEvent::class;
    }
}
