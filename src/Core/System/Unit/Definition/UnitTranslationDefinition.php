<?php declare(strict_types=1);

namespace Shopware\System\Unit\Definition;

use Shopware\Framework\ORM\EntityDefinition;
use Shopware\Framework\ORM\EntityExtensionInterface;
use Shopware\Framework\ORM\Field\FkField;
use Shopware\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Framework\ORM\Field\ReferenceVersionField;
use Shopware\Framework\ORM\Field\StringField;
use Shopware\Framework\ORM\FieldCollection;
use Shopware\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Framework\ORM\Write\Flag\Required;
use Shopware\System\Unit\Aggregate\UnitTranslation\Collection\UnitTranslationBasicCollection;
use Shopware\System\Unit\Aggregate\UnitTranslation\Collection\UnitTranslationDetailCollection;
use Shopware\System\Unit\Aggregate\UnitTranslation\Event\UnitTranslationDeletedEvent;
use Shopware\System\Unit\Aggregate\UnitTranslation\Event\UnitTranslationWrittenEvent;
use Shopware\System\Unit\Aggregate\UnitTranslation\Struct\UnitTranslationBasicStruct;
use Shopware\System\Unit\Aggregate\UnitTranslation\Struct\UnitTranslationDetailStruct;
use Shopware\System\Unit\Aggregate\UnitTranslation\UnitTranslationRepository;
use Shopware\System\Unit\UnitDefinition;

class UnitTranslationDefinition extends EntityDefinition
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
        return 'unit_translation';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            (new FkField('unit_id', 'unitId', UnitDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(UnitDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new FkField('language_id', 'languageId', \Shopware\Application\Language\LanguageDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('short_code', 'shortCode'))->setFlags(new Required()),
            (new StringField('name', 'name'))->setFlags(new Required()),
            new ManyToOneAssociationField('unit', 'unit_id', UnitDefinition::class, false),
            new ManyToOneAssociationField('language', 'language_id', \Shopware\Application\Language\LanguageDefinition::class, false),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return UnitTranslationRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return UnitTranslationBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return UnitTranslationDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return UnitTranslationWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return UnitTranslationBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDetailStructClass(): string
    {
        return UnitTranslationDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return UnitTranslationDetailCollection::class;
    }
}
