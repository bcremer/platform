<?php declare(strict_types=1);

namespace Shopware\Checkout\Rule\Collection;

use Shopware\Application\Context\Struct\StorefrontContext;
use Shopware\Checkout\Cart\Cart\Struct\CalculatedCart;
use Shopware\Checkout\Rule\Specification\Scope\CartRuleScope;
use Shopware\Checkout\Rule\Struct\ContextRuleBasicStruct;
use Shopware\Framework\ORM\EntityCollection;

class ContextRuleBasicCollection extends EntityCollection
{
    /**
     * @var ContextRuleBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? ContextRuleBasicStruct
    {
        return parent::get($id);
    }

    public function current(): ContextRuleBasicStruct
    {
        return parent::current();
    }

    public function filterMatchingRules(CalculatedCart $cart, StorefrontContext $context)
    {
        return $this->filter(
            function (ContextRuleBasicStruct $rule) use ($cart, $context) {
                return $rule->getPayload()->match(new CartRuleScope($cart, $context))->matches();
            }
        );
    }

    public function sortByPriority(): void
    {
        $this->sort(function (ContextRuleBasicStruct $a, ContextRuleBasicStruct $b) {
            return $b->getPriority() <=> $a->getPriority();
        });
    }

    protected function getExpectedClass(): string
    {
        return ContextRuleBasicStruct::class;
    }
}
