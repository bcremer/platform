<?php
declare(strict_types=1);
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

namespace Shopware\Checkout\Cart;

use Shopware\Application\Context\Struct\StorefrontContext;
use Shopware\Checkout\Cart\Cart\CartPersisterInterface;
use Shopware\Checkout\Cart\Cart\CircularCartCalculation;
use Shopware\Checkout\Cart\Cart\Struct\CalculatedCart;
use Shopware\Checkout\Cart\Cart\Struct\Cart;
use Shopware\Checkout\Cart\Exception\LineItemNotFoundException;
use Shopware\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Checkout\Cart\LineItem\LineItemInterface;
use Shopware\Checkout\Cart\Order\OrderPersisterInterface;
use Shopware\Checkout\Order\OrderDefinition;

class StoreFrontCartService
{
    public const CART_NAME = 'shopware';

    /**
     * @var CircularCartCalculation
     */
    private $calculation;

    /**
     * @var CartPersisterInterface
     */
    private $persister;

    /**
     * @var OrderPersisterInterface
     */
    private $orderPersister;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var CalculatedCart|null
     */
    private $calculated;

    public function __construct(
        CircularCartCalculation $calculation,
        CartPersisterInterface $persister,
        OrderPersisterInterface $orderPersister
    ) {
        $this->calculation = $calculation;
        $this->persister = $persister;
        $this->orderPersister = $orderPersister;
    }

    public function setCalculated(CalculatedCart $calculatedCart): void
    {
        $this->cart = $calculatedCart->getCart();
        $this->calculated = $calculatedCart;
    }

    public function createNew(StorefrontContext $context): CalculatedCart
    {
        $this->createNewCart($context);

        return $this->getCalculatedCart($context);
    }

    public function getCalculatedCart(StorefrontContext $context): CalculatedCart
    {
        if ($this->calculated) {
            return $this->calculated;
        }

        $container = $this->getCart($context);

        return $this->calculate($container, $context);
    }

    public function add(LineItemInterface $item, StorefrontContext $context): void
    {
        $cart = $this->getCart($context);

        $cart->getLineItems()->add($item);

        $this->calculate($cart, $context);
    }

    public function fill(LineItemCollection $lineItems, StorefrontContext $context): void
    {
        $cart = $this->getCart($context);

        $cart->getLineItems()->fill($lineItems->getElements());

        $this->calculate($cart, $context);
    }

    /**
     * @throws LineItemNotFoundException
     */
    public function changeQuantity(string $identifier, int $quantity, StorefrontContext $context): void
    {
        $cart = $this->getCart($context);

        if (!$lineItem = $cart->getLineItems()->get($identifier)) {
            throw new LineItemNotFoundException($identifier);
        }

        $lineItem->setQuantity($quantity);

        $this->calculate($cart, $context);
    }

    public function remove(string $identifier, StorefrontContext $context): void
    {
        $cart = $this->getCart($context);
        $cart->getLineItems()->remove($identifier);
        $this->calculate($cart, $context);
    }

    public function order(StorefrontContext $context): string
    {
        $events = $this->orderPersister->persist(
            $this->getCalculatedCart($context),
            $context
        );

        $this->createNewCart($context);

        $event = $events->getEventByDefinition(OrderDefinition::class);
        $ids = $event->getIds();

        return array_shift($ids);
    }

    public function getCart(StorefrontContext $context): Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        try {
            //try to access existing cart, identified by session token
            return $this->cart = $this->persister->load(
                $context->getToken(),
                self::CART_NAME,
                $context
            );
        } catch (\Exception $e) {
            //token not found, create new cart
            return $this->cart = $this->createNewCart($context);
        }
    }

    private function calculate(Cart $cart, StorefrontContext $context): CalculatedCart
    {
        $calculated = $this->calculation->calculate($cart, $context);

        $this->save($calculated, $context);

        $this->calculated = $calculated;

        return $calculated;
    }

    private function save(CalculatedCart $calculatedCart, StorefrontContext $context): void
    {
        $this->persister->save($calculatedCart, $context);

        $this->cart = $calculatedCart->getCart();
    }

    private function createNewCart(StorefrontContext $context): Cart
    {
        $this->persister->delete($context->getToken(), self::CART_NAME, $context);
        $this->cart = Cart::createNew(self::CART_NAME, $context->getToken());
        $this->calculated = null;

        return $this->cart;
    }
}
