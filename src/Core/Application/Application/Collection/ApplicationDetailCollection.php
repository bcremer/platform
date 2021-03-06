<?php declare(strict_types=1);

namespace Shopware\Application\Application\Collection;

use Shopware\Application\Application\Struct\ApplicationDetailStruct;
use Shopware\Checkout\Payment\Collection\PaymentMethodBasicCollection;
use Shopware\Checkout\Shipping\Collection\ShippingMethodBasicCollection;
use Shopware\System\Country\Collection\CountryBasicCollection;

class ApplicationDetailCollection extends ApplicationBasicCollection
{
    /**
     * @var ApplicationDetailStruct[]
     */
    protected $elements = [];

    public function getPaymentMethods(): PaymentMethodBasicCollection
    {
        return new PaymentMethodBasicCollection(
            $this->fmap(function (ApplicationDetailStruct $application) {
                return $application->getPaymentMethod();
            })
        );
    }

    public function getShippingMethods(): ShippingMethodBasicCollection
    {
        return new ShippingMethodBasicCollection(
            $this->fmap(function (ApplicationDetailStruct $application) {
                return $application->getShippingMethod();
            })
        );
    }

    public function getCountries(): CountryBasicCollection
    {
        return new CountryBasicCollection(
            $this->fmap(function (ApplicationDetailStruct $application) {
                return $application->getCountry();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return ApplicationDetailStruct::class;
    }
}
