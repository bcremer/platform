<?php declare(strict_types=1);

namespace Shopware\System\Locale\Event;

use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\System\Locale\LocaleDefinition;

class LocaleWrittenEvent extends WrittenEvent
{
    public const NAME = 'locale.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return LocaleDefinition::class;
    }
}
