<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Aggregate\ConfigurationGroupTranslation\Event;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\System\Configuration\Aggregate\ConfigurationGroupTranslation\ConfigurationGroupTranslationDefinition;

class ConfigurationGroupTranslationDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'configuration_group_translation.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ConfigurationGroupTranslationDefinition::class;
    }
}
