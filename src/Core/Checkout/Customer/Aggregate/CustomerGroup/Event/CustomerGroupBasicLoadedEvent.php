<?php declare(strict_types=1);

namespace Shopware\Checkout\Customer\Aggregate\CustomerGroup\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Customer\Aggregate\CustomerGroup\Collection\CustomerGroupBasicCollection;
use Shopware\Framework\Event\NestedEvent;

class CustomerGroupBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'customer_group.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var \Shopware\Checkout\Customer\Aggregate\CustomerGroup\Collection\CustomerGroupBasicCollection
     */
    protected $customerGroups;

    public function __construct(CustomerGroupBasicCollection $customerGroups, ApplicationContext $context)
    {
        $this->context = $context;
        $this->customerGroups = $customerGroups;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getCustomerGroups(): CustomerGroupBasicCollection
    {
        return $this->customerGroups;
    }
}
