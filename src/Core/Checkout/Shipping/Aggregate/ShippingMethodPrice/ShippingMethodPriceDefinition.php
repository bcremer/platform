<?php declare(strict_types=1);

namespace Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice;

use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Collection\ShippingMethodPriceBasicCollection;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Collection\ShippingMethodPriceDetailCollection;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Event\ShippingMethodPriceDeletedEvent;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Event\ShippingMethodPriceWrittenEvent;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Struct\ShippingMethodPriceBasicStruct;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodPrice\Struct\ShippingMethodPriceDetailStruct;
use Shopware\Checkout\Shipping\ShippingMethodDefinition;
use Shopware\Framework\ORM\EntityDefinition;
use Shopware\Framework\ORM\EntityExtensionInterface;
use Shopware\Framework\ORM\Field\DateField;
use Shopware\Framework\ORM\Field\FkField;
use Shopware\Framework\ORM\Field\FloatField;
use Shopware\Framework\ORM\Field\IdField;
use Shopware\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Framework\ORM\Field\ReferenceVersionField;
use Shopware\Framework\ORM\Field\TenantIdField;
use Shopware\Framework\ORM\Field\VersionField;
use Shopware\Framework\ORM\FieldCollection;
use Shopware\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Framework\ORM\Write\Flag\Required;

class ShippingMethodPriceDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'shipping_method_price';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            new TenantIdField(),
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            new VersionField(),

            (new FkField('shipping_method_id', 'shippingMethodId', ShippingMethodDefinition::class))->setFlags(new Required()),
            (new ReferenceVersionField(ShippingMethodDefinition::class))->setFlags(new Required()),

            (new FloatField('quantity_from', 'quantityFrom'))->setFlags(new Required()),
            (new FloatField('price', 'price'))->setFlags(new Required()),
            (new FloatField('factor', 'factor'))->setFlags(new Required()),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            new ManyToOneAssociationField('shippingMethod', 'shipping_method_id', ShippingMethodDefinition::class, false),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return ShippingMethodPriceRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return ShippingMethodPriceBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return ShippingMethodPriceDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return ShippingMethodPriceWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return ShippingMethodPriceBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDetailStructClass(): string
    {
        return ShippingMethodPriceDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return ShippingMethodPriceDetailCollection::class;
    }
}
