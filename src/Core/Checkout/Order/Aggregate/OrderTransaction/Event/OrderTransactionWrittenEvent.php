<?php declare(strict_types=1);

namespace Shopware\Checkout\Order\Aggregate\OrderTransaction\Event;

use Shopware\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionDefinition;
use Shopware\Framework\ORM\Write\WrittenEvent;

class OrderTransactionWrittenEvent extends WrittenEvent
{
    public const NAME = 'order_transaction.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return OrderTransactionDefinition::class;
    }
}
