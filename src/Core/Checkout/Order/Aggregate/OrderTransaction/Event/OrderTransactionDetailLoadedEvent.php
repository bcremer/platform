<?php declare(strict_types=1);

namespace Shopware\Checkout\Order\Aggregate\OrderTransaction\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Order\Aggregate\OrderTransaction\Collection\OrderTransactionDetailCollection;
use Shopware\Checkout\Payment\Event\PaymentMethodBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class OrderTransactionDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'order_transaction.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var OrderTransactionDetailCollection
     */
    protected $orderTransactions;

    public function __construct(OrderTransactionDetailCollection $orderTransactions, ApplicationContext $context)
    {
        $this->context = $context;
        $this->orderTransactions = $orderTransactions;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getOrderTransactions(): OrderTransactionDetailCollection
    {
        return $this->orderTransactions;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->orderTransactions->getPaymentMethods()->count() > 0) {
            $events[] = new PaymentMethodBasicLoadedEvent($this->orderTransactions->getPaymentMethods(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
