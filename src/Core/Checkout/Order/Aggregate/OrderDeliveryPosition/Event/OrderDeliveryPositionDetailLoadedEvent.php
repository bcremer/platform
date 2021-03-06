<?php declare(strict_types=1);

namespace Shopware\Checkout\Order\Aggregate\OrderDeliveryPosition\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Order\Aggregate\OrderDelivery\Event\OrderDeliveryBasicLoadedEvent;
use Shopware\Checkout\Order\Aggregate\OrderDeliveryPosition\Collection\OrderDeliveryPositionDetailCollection;
use Shopware\Checkout\Order\Aggregate\OrderLineItem\Event\OrderLineItemBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class OrderDeliveryPositionDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'order_delivery_position.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var \Shopware\Checkout\Order\Aggregate\OrderDeliveryPosition\Collection\OrderDeliveryPositionDetailCollection
     */
    protected $orderDeliveryPositions;

    public function __construct(OrderDeliveryPositionDetailCollection $orderDeliveryPositions, ApplicationContext $context)
    {
        $this->context = $context;
        $this->orderDeliveryPositions = $orderDeliveryPositions;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getOrderDeliveryPositions(): OrderDeliveryPositionDetailCollection
    {
        return $this->orderDeliveryPositions;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->orderDeliveryPositions->getOrderDeliveries()->count() > 0) {
            $events[] = new OrderDeliveryBasicLoadedEvent($this->orderDeliveryPositions->getOrderDeliveries(), $this->context);
        }
        if ($this->orderDeliveryPositions->getOrderLineItems()->count() > 0) {
            $events[] = new OrderLineItemBasicLoadedEvent($this->orderDeliveryPositions->getOrderLineItems(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
