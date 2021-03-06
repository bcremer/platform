<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductContextPrice\Struct;

use Shopware\Checkout\Rule\Struct\ContextRuleBasicStruct;
use Shopware\Content\Product\Struct\ProductBasicStruct;
use Shopware\System\Currency\Struct\CurrencyBasicStruct;

class ProductContextPriceDetailStruct extends ProductContextPriceBasicStruct
{
    /**
     * @var ProductBasicStruct
     */
    protected $product;

    /**
     * @var CurrencyBasicStruct
     */
    protected $currency;

    /**
     * @var ContextRuleBasicStruct
     */
    protected $contextRule;

    public function getProduct(): ProductBasicStruct
    {
        return $this->product;
    }

    public function setProduct(ProductBasicStruct $product): void
    {
        $this->product = $product;
    }

    public function getCurrency(): CurrencyBasicStruct
    {
        return $this->currency;
    }

    public function setCurrency(CurrencyBasicStruct $currency): void
    {
        $this->currency = $currency;
    }

    public function getContextRule(): \Shopware\Checkout\Rule\Struct\ContextRuleBasicStruct
    {
        return $this->contextRule;
    }

    public function setContextRule(\Shopware\Checkout\Rule\Struct\ContextRuleBasicStruct $contextRule): void
    {
        $this->contextRule = $contextRule;
    }
}
