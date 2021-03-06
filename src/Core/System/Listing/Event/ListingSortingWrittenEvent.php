<?php declare(strict_types=1);

namespace Shopware\System\Listing\Event;

use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\System\Listing\ListingSortingDefinition;

class ListingSortingWrittenEvent extends WrittenEvent
{
    public const NAME = 'listing_sorting.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ListingSortingDefinition::class;
    }
}
