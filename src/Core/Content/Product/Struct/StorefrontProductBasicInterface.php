<?php declare(strict_types=1);

namespace Shopware\Content\Product\Struct;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Cart\Price\Struct\CalculatedPrice;
use Shopware\Checkout\Cart\Price\Struct\CalculatedPriceCollection;
use Shopware\Checkout\Cart\Price\Struct\PriceDefinition;
use Shopware\Checkout\Cart\Price\Struct\PriceDefinitionCollection;

interface StorefrontProductBasicInterface
{
    public function isAvailable(): bool;

    public function getCalculatedListingPrice(): CalculatedPrice;

    public function setCalculatedListingPrice(CalculatedPrice $calculatedListingPrice): void;

    public function setCalculatedContextPrices(CalculatedPriceCollection $prices): void;

    public function getCalculatedContextPrices(): CalculatedPriceCollection;

    public function getCalculatedPrice(): CalculatedPrice;

    public function setCalculatedPrice(CalculatedPrice $calculatedPrice): void;

    public function getListingPriceDefinition(ApplicationContext $context): PriceDefinition;

    public function getContextPriceDefinitions(ApplicationContext $context): PriceDefinitionCollection;

    public function getPriceDefinition(ApplicationContext $context): PriceDefinition;
}
