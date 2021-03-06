<?php declare(strict_types=1);

namespace Shopware\Checkout\Payment\Event;

use Shopware\Checkout\Payment\PaymentMethodDefinition;
use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;

class PaymentMethodDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'payment_method.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return PaymentMethodDefinition::class;
    }
}
