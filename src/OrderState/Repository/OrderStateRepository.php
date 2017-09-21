<?php declare(strict_types=1);

namespace Shopware\OrderState\Repository;

use Shopware\Context\Struct\TranslationContext;
use Shopware\OrderState\Event\OrderStateBasicLoadedEvent;
use Shopware\OrderState\Event\OrderStateWrittenEvent;
use Shopware\OrderState\Loader\OrderStateBasicLoader;
use Shopware\OrderState\Searcher\OrderStateSearcher;
use Shopware\OrderState\Searcher\OrderStateSearchResult;
use Shopware\OrderState\Struct\OrderStateBasicCollection;
use Shopware\OrderState\Writer\OrderStateWriter;
use Shopware\Search\AggregationResult;
use Shopware\Search\Criteria;
use Shopware\Search\UuidSearchResult;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderStateRepository
{
    /**
     * @var OrderStateBasicLoader
     */
    private $basicLoader;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var OrderStateSearcher
     */
    private $searcher;

    /**
     * @var OrderStateWriter
     */
    private $writer;

    public function __construct(
        OrderStateBasicLoader $basicLoader,
        EventDispatcherInterface $eventDispatcher,
        OrderStateSearcher $searcher,
        OrderStateWriter $writer
    ) {
        $this->basicLoader = $basicLoader;
        $this->eventDispatcher = $eventDispatcher;
        $this->searcher = $searcher;
        $this->writer = $writer;
    }

    public function read(array $uuids, TranslationContext $context): OrderStateBasicCollection
    {
        if (empty($uuids)) {
            return new OrderStateBasicCollection();
        }

        $collection = $this->basicLoader->load($uuids, $context);

        $this->eventDispatcher->dispatch(
            OrderStateBasicLoadedEvent::NAME,
            new OrderStateBasicLoadedEvent($collection, $context)
        );

        return $collection;
    }

    public function search(Criteria $criteria, TranslationContext $context): OrderStateSearchResult
    {
        /** @var OrderStateSearchResult $result */
        $result = $this->searcher->search($criteria, $context);

        $this->eventDispatcher->dispatch(
            OrderStateBasicLoadedEvent::NAME,
            new OrderStateBasicLoadedEvent($result, $context)
        );

        return $result;
    }

    public function searchUuids(Criteria $criteria, TranslationContext $context): UuidSearchResult
    {
        return $this->searcher->searchUuids($criteria, $context);
    }

    public function aggregate(Criteria $criteria, TranslationContext $context): AggregationResult
    {
        $result = $this->searcher->aggregate($criteria, $context);

        return $result;
    }

    public function update(array $data, TranslationContext $context): OrderStateWrittenEvent
    {
        $event = $this->writer->update($data, $context);

        $this->eventDispatcher->dispatch($event::NAME, $event);

        return $event;
    }

    public function upsert(array $data, TranslationContext $context): OrderStateWrittenEvent
    {
        $event = $this->writer->upsert($data, $context);

        $this->eventDispatcher->dispatch($event::NAME, $event);

        return $event;
    }

    public function create(array $data, TranslationContext $context): OrderStateWrittenEvent
    {
        $event = $this->writer->create($data, $context);

        $this->eventDispatcher->dispatch($event::NAME, $event);

        return $event;
    }
}