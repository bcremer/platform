<?php declare(strict_types=1);

namespace Shopware\System\Listing\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Listing\Aggregate\ListingSortingTranslation\Event\ListingSortingTranslationBasicLoadedEvent;
use Shopware\System\Listing\Collection\ListingSortingDetailCollection;

class ListingSortingDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'listing_sorting.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ListingSortingDetailCollection
     */
    protected $listingSortings;

    public function __construct(ListingSortingDetailCollection $listingSortings, ApplicationContext $context)
    {
        $this->context = $context;
        $this->listingSortings = $listingSortings;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getListingSortings(): ListingSortingDetailCollection
    {
        return $this->listingSortings;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->listingSortings->getTranslations()->count() > 0) {
            $events[] = new ListingSortingTranslationBasicLoadedEvent($this->listingSortings->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
