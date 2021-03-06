<?php declare(strict_types=1);
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Checkout\Test\Cart\Common;

use PHPUnit\Framework\TestCase;
use Shopware\Application\Application\Struct\ApplicationBasicStruct;
use Shopware\Application\Context\Struct\StorefrontContext;
use Shopware\Application\Language\Struct\LanguageBasicStruct;
use Shopware\Checkout\Cart\Cart\Struct\CalculatedCart;
use Shopware\Checkout\Cart\Cart\Struct\Cart;
use Shopware\Checkout\Cart\Delivery\DeliveryCalculator;
use Shopware\Checkout\Cart\Delivery\Struct\DeliveryCollection;
use Shopware\Checkout\Cart\Delivery\Struct\DeliveryDate;
use Shopware\Checkout\Cart\Delivery\Struct\ShippingLocation;
use Shopware\Checkout\Cart\Error\ErrorCollection;
use Shopware\Checkout\Cart\LineItem\CalculatedLineItemCollection;
use Shopware\Checkout\Cart\LineItem\LineItem;
use Shopware\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Checkout\Cart\Price\Struct\CalculatedPrice;
use Shopware\Checkout\Cart\Price\Struct\CartPrice;
use Shopware\Checkout\Cart\Tax\Struct\CalculatedTaxCollection;
use Shopware\Checkout\Cart\Tax\Struct\TaxRuleCollection;
use Shopware\Checkout\Cart\Tax\TaxAmountCalculator;
use Shopware\Checkout\Cart\Tax\TaxDetector;
use Shopware\Checkout\Customer\Aggregate\CustomerAddress\Struct\CustomerAddressBasicStruct;
use Shopware\Checkout\Customer\Aggregate\CustomerGroup\Struct\CustomerGroupBasicStruct;
use Shopware\Checkout\Customer\Struct\CustomerBasicStruct;
use Shopware\Checkout\Payment\Struct\PaymentMethodBasicStruct;
use Shopware\Checkout\Shipping\Struct\ShippingMethodBasicStruct;
use Shopware\Content\Product\Cart\ProductProcessor;
use Shopware\Content\Product\Cart\Struct\CalculatedProduct;
use Shopware\Content\Product\Struct\ProductBasicStruct;
use Shopware\Defaults;
use Shopware\Framework\Struct\Uuid;
use Shopware\System\Country\Aggregate\CountryArea\Struct\CountryAreaBasicStruct;
use Shopware\System\Country\Aggregate\CountryState\Struct\CountryStateBasicStruct;
use Shopware\System\Country\Struct\CountryBasicStruct;
use Shopware\System\Currency\Struct\CurrencyBasicStruct;
use Shopware\System\Locale\Struct\LocaleBasicStruct;
use Shopware\System\Tax\Collection\TaxBasicCollection;
use Shopware\System\Tax\Struct\TaxBasicStruct;

class Generator extends TestCase
{
    public static function createContext(
        $currentCustomerGroup = null,
        $fallbackCustomerGroup = null,
        $application = null,
        $currency = null,
        $priceGroupDiscounts = null,
        $taxes = null,
        $area = null,
        $country = null,
        $state = null,
        $shipping = null,
        $language = null,
        $fallbackLanguage = null
    ) {
        if ($application === null) {
            $application = new ApplicationBasicStruct();
            $application->setId('ffa32a50e2d04cf38389a53f8d6cd594');
            $application->setTaxCalculationType(TaxAmountCalculator::CALCULATION_HORIZONTAL);
            $application->setCatalogIds([Defaults::CATALOG]);
        }

        $currency = $currency ?: (new CurrencyBasicStruct())->assign([
            'id' => '4c8eba11-bd35-46d7-86af-bed481a6e665',
            'factor' => 1,
        ]);

        $currency->setFactor(1);

        if (!$currentCustomerGroup) {
            $currentCustomerGroup = new CustomerGroupBasicStruct();
            $currentCustomerGroup->setId(Defaults::FALLBACK_CUSTOMER_GROUP);
            $currentCustomerGroup->setDisplayGross(true);
        }

        if (!$fallbackCustomerGroup) {
            $fallbackCustomerGroup = new CustomerGroupBasicStruct();
            $fallbackCustomerGroup->setId(Defaults::FALLBACK_CUSTOMER_GROUP);
            $currentCustomerGroup->setDisplayGross(true);
        }

        if (!$taxes) {
            $tax = new TaxBasicStruct();
            $tax->setId('49260353-68e3-4d9f-a695-e017d7a231b9');
            $tax->setName('test');
            $tax->setRate(19.0);

            $taxes = new TaxBasicCollection([$tax]);
        }

        if (!$area) {
            $area = new CountryAreaBasicStruct();
            $area->setId('5cff02b1-0297-41a4-891c-430bcd9e3603');
        }

        if (!$country) {
            $country = new CountryBasicStruct();
            $country->setId('5cff02b1-0297-41a4-891c-430bcd9e3603');
            $country->setAreaId($area->getId());
            $country->setTaxFree(false);
            $country->setName('Germany');
        }
        if (!$state) {
            $state = new CountryStateBasicStruct();
            $state->setId('bd5e2dcf-547e-4df6-bb1f-f58a554bc69e');
            $state->setCountryId($country->getId());
        }

        if (!$shipping) {
            $shipping = new CustomerAddressBasicStruct();
            $shipping->setCountry($country);
            $shipping->setCountryState($state);
        }

        if (!$language) {
            $locale = new LocaleBasicStruct();
            $locale->setCode('en_GB');

            $language = new LanguageBasicStruct();
            $language->setId(Defaults::LANGUAGE);
            $language->setLocale($locale);
            $language->setName('Language 1');
        }

        if (!$fallbackLanguage) {
            $locale = new LocaleBasicStruct();
            $locale->setCode('en_GB');

            $fallbackLanguage = new LanguageBasicStruct();
            $fallbackLanguage->setLocale($locale);
            $fallbackLanguage->setName('Fallback Language 1');
        }

        $paymentMethod = (new PaymentMethodBasicStruct())->assign(['id' => '19d144ff-e15f-4772-860d-59fca7f207c1']);
        $shippingMethod = new ShippingMethodBasicStruct();
        $shippingMethod->setId('8beeb66e9dda46b18891a059257a590e');
        $shippingMethod->setCalculation(DeliveryCalculator::CALCULATION_BY_PRICE);
        $shippingMethod->setMinDeliveryTime(1);
        $shippingMethod->setMaxDeliveryTime(2);

        $customer = (new CustomerBasicStruct())->assign(['id' => Uuid::uuid4()->getHex()]);
        $customer->setId(Uuid::uuid4()->getHex());
        $customer->setGroup($currentCustomerGroup);

        return new StorefrontContext(
            Defaults::TENANT_ID,
            Uuid::uuid4()->toString(),
            $application,
            $language,
            $fallbackLanguage,
            $currency,
            $currentCustomerGroup,
            $fallbackCustomerGroup,
            $taxes,
            $paymentMethod,
            $shippingMethod,
            ShippingLocation::createFromAddress($shipping),
            $customer,
            []
        );
    }

    public static function createGrossPriceDetector()
    {
        $self = new self();

        return $self->createTaxDetector(true, false);
    }

    public static function createNetPriceDetector()
    {
        $self = new self();

        return $self->createTaxDetector(false, false);
    }

    public static function createNetDeliveryDetector()
    {
        $self = new self();

        return $self->createTaxDetector(false, true);
    }

    /**
     * @param \Shopware\Checkout\Cart\Price\Struct\PriceDefinition[] $priceDefinitions indexed by product number
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ProductPriceGateway
     */
    public function createProductPriceGateway($priceDefinitions)
    {
        $mock = $this->createMock(ProductPriceGateway::class);
        $mock->expects(static::any())
            ->method('get')
            ->will(static::returnValue($priceDefinitions));

        return $mock;
    }

    public static function createCalculatedCart(): CalculatedCart
    {
        return new CalculatedCart(
            new Cart('test', 'test', new LineItemCollection(), new ErrorCollection()),
            new CalculatedLineItemCollection([
                self::createCalculatedProduct('A', 10, 27),
                new TestLineItem('B', null, 5),
            ]),
            new CartPrice(275, 275, 0, new CalculatedTaxCollection(), new TaxRuleCollection(), CartPrice::TAX_STATE_GROSS),
            new DeliveryCollection()
        );
    }

    public static function createCalculatedProduct(
        string $identifier,
        float $price,
        int $quantity,
        ?ProductBasicStruct $productBasicStruct = null
    ): CalculatedProduct {
        $product = $productBasicStruct ?? new ProductBasicStruct();

        return new CalculatedProduct(
            new LineItem($identifier, ProductProcessor::TYPE_PRODUCT, $quantity),
            new CalculatedPrice($price, $price * $quantity, new CalculatedTaxCollection(), new TaxRuleCollection(), $quantity),
            $identifier,
            $quantity,
            new DeliveryDate(new \DateTime(), new \DateTime()),
            new DeliveryDate(new \DateTime(), new \DateTime()),
            $product
        );
    }

    private function createTaxDetector($useGross, $isNetDelivery)
    {
        $mock = $this->createMock(TaxDetector::class);
        $mock->expects(static::any())
            ->method('useGross')
            ->will(static::returnValue($useGross));

        $mock->expects(static::any())
            ->method('isNetDelivery')
            ->will(static::returnValue($isNetDelivery));

        return $mock;
    }
}
