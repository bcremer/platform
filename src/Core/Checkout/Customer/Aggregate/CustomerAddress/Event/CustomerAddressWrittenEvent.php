<?php declare(strict_types=1);

namespace Shopware\Checkout\Customer\Aggregate\CustomerAddress\Event;

use Shopware\Checkout\Customer\Aggregate\CustomerAddress\CustomerAddressDefinition;
use Shopware\Framework\ORM\Write\WrittenEvent;

class CustomerAddressWrittenEvent extends WrittenEvent
{
    public const NAME = 'customer_address.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return CustomerAddressDefinition::class;
    }
}
