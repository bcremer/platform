<?php declare(strict_types=1);

namespace Shopware\Profiling\Cart;

use Shopware\Application\Context\Struct\StorefrontContext;
use Shopware\Checkout\Cart\Cart\CircularCartCalculation;
use Shopware\Checkout\Cart\Cart\Struct\CalculatedCart;
use Shopware\Checkout\Cart\Cart\Struct\Cart;

class CircularCartCalculationTracer extends CircularCartCalculation
{
    /**
     * @var CircularCartCalculation
     */
    private $calculator;

    /**
     * @var TracedCartActions
     */
    private $actions;

    public function __construct(
        CircularCartCalculation $calculator,
        TracedCartActions $actions
    ) {
        $this->calculator = $calculator;
        $this->actions = $actions;
    }

    public function calculate(Cart $cart, StorefrontContext $context): CalculatedCart
    {
        $time = microtime(true);
        $calculatedCart = $this->calculator->calculate($cart, $context);

        $required = microtime(true) - $time;
        $this->actions->calculationTime = $required;
        $this->actions->calculatedCart = $calculatedCart;
        $this->actions->cart = $cart;
        $this->actions->context = $context;

        return $calculatedCart;
    }
}
