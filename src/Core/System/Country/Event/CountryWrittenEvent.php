<?php declare(strict_types=1);

namespace Shopware\System\Country\Event;

use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\System\Country\CountryDefinition;

class CountryWrittenEvent extends WrittenEvent
{
    public const NAME = 'country.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return CountryDefinition::class;
    }
}
