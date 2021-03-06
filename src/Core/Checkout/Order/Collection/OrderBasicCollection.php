<?php declare(strict_types=1);

namespace Shopware\Checkout\Order\Collection;

use Shopware\Application\Application\Collection\ApplicationBasicCollection;
use Shopware\Checkout\Customer\Collection\CustomerBasicCollection;
use Shopware\Checkout\Order\Aggregate\OrderAddress\Collection\OrderAddressBasicCollection;
use Shopware\Checkout\Order\Aggregate\OrderState\Collection\OrderStateBasicCollection;
use Shopware\Checkout\Order\Struct\OrderBasicStruct;
use Shopware\Checkout\Payment\Collection\PaymentMethodBasicCollection;
use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Currency\Collection\CurrencyBasicCollection;

class OrderBasicCollection extends EntityCollection
{
    /**
     * @var OrderBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? OrderBasicStruct
    {
        return parent::get($id);
    }

    public function current(): OrderBasicStruct
    {
        return parent::current();
    }

    public function getCustomerIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getCustomerId();
        });
    }

    public function filterByCustomerId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getCustomerId() === $id;
        });
    }

    public function getStateIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getStateId();
        });
    }

    public function filterByStateId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getStateId() === $id;
        });
    }

    public function getPaymentMethodIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getPaymentMethodId();
        });
    }

    public function filterByPaymentMethodId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getPaymentMethodId() === $id;
        });
    }

    public function getCurrencyIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getCurrencyId();
        });
    }

    public function filterByCurrencyId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getCurrencyId() === $id;
        });
    }

    public function getApplicationIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getApplicationId();
        });
    }

    public function filterByApplicationId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getApplicationId() === $id;
        });
    }

    public function getBillingAddressIds(): array
    {
        return $this->fmap(function (OrderBasicStruct $order) {
            return $order->getBillingAddressId();
        });
    }

    public function filterByBillingAddressId(string $id): self
    {
        return $this->filter(function (OrderBasicStruct $order) use ($id) {
            return $order->getBillingAddressId() === $id;
        });
    }

    public function getCustomers(): CustomerBasicCollection
    {
        return new CustomerBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getCustomer();
            })
        );
    }

    public function getStates(): OrderStateBasicCollection
    {
        return new OrderStateBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getState();
            })
        );
    }

    public function getPaymentMethods(): PaymentMethodBasicCollection
    {
        return new PaymentMethodBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getPaymentMethod();
            })
        );
    }

    public function getCurrencies(): CurrencyBasicCollection
    {
        return new CurrencyBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getCurrency();
            })
        );
    }

    public function getApplications(): ApplicationBasicCollection
    {
        return new ApplicationBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getApplication();
            })
        );
    }

    public function getBillingAddress(): OrderAddressBasicCollection
    {
        return new OrderAddressBasicCollection(
            $this->fmap(function (OrderBasicStruct $order) {
                return $order->getBillingAddress();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return OrderBasicStruct::class;
    }
}
