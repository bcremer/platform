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

namespace Shopware\Content\Product\Cart\Struct;

use Shopware\Checkout\Cart\Delivery\Struct\Delivery;
use Shopware\Checkout\Cart\Delivery\Struct\DeliveryDate;
use Shopware\Checkout\Cart\LineItem\CalculatedLineItemCollection;
use Shopware\Checkout\Cart\LineItem\CalculatedLineItemInterface;
use Shopware\Checkout\Cart\LineItem\DeliverableLineItemInterface;
use Shopware\Checkout\Cart\LineItem\GoodsInterface;
use Shopware\Checkout\Cart\LineItem\LineItemInterface;
use Shopware\Checkout\Cart\LineItem\NestedInterface;
use Shopware\Checkout\Cart\Price\Struct\CalculatedPrice;
use Shopware\Checkout\Rule\Specification\Rule;
use Shopware\Checkout\Rule\Specification\Validatable;
use Shopware\Content\Media\Struct\MediaBasicStruct;
use Shopware\Content\Product\Struct\ProductBasicStruct;
use Shopware\Framework\Struct\Struct;

class CalculatedProduct extends Struct implements DeliverableLineItemInterface, GoodsInterface, Validatable, NestedInterface
{
    /**
     * @var LineItemInterface
     */
    protected $lineItem;

    /**
     * @var CalculatedPrice
     */
    protected $price;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var null|Delivery
     */
    protected $delivery;

    /**
     * @var null|Rule
     */
    protected $rule;

    /**
     * @var MediaBasicStruct|null
     */
    protected $cover;

    /**
     * @var \Shopware\Checkout\Cart\Delivery\Struct\DeliveryDate
     */
    protected $inStockDeliveryDate;

    /**
     * @var \Shopware\Checkout\Cart\Delivery\Struct\DeliveryDate
     */
    protected $outOfStockDeliveryDate;

    /**
     * @var ProductBasicStruct
     */
    protected $product;

    /**
     * @var CalculatedLineItemCollection
     */
    protected $children;

    public function __construct(
        LineItemInterface $lineItem,
        CalculatedPrice $price,
        string $identifier,
        int $quantity,
        DeliveryDate $inStockDeliveryDate,
        DeliveryDate $outOfStockDeliveryDate,
        ProductBasicStruct $product,
        ?CalculatedLineItemCollection $children = null,
        ?Rule $rule = null,
        ?MediaBasicStruct $cover = null
    ) {
        $this->lineItem = $lineItem;
        $this->price = $price;
        $this->identifier = $identifier;
        $this->quantity = $quantity;
        $this->product = $product;
        $this->rule = $rule;
        $this->cover = $cover;
        $this->inStockDeliveryDate = $inStockDeliveryDate;
        $this->outOfStockDeliveryDate = $outOfStockDeliveryDate;

        if ($children === null) {
            $children = new CalculatedLineItemCollection();
        }
        $this->children = $children;
    }

    public function addChild(CalculatedLineItemInterface $lineItem)
    {
        $this->children->add($lineItem);
    }

    public function getChildren(): CalculatedLineItemCollection
    {
        return $this->children;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPrice(): CalculatedPrice
    {
        return $this->price;
    }

    public function considerChildrenPrices(): bool
    {
        return true;
    }

    public function getProduct(): ProductBasicStruct
    {
        return $this->product;
    }

    public function getStock(): int
    {
        return $this->product->getStock() ?? 0;
    }

    public function getInStockDeliveryDate(): DeliveryDate
    {
        return $this->inStockDeliveryDate;
    }

    public function getOutOfStockDeliveryDate(): DeliveryDate
    {
        return $this->outOfStockDeliveryDate;
    }

    public function getWeight(): float
    {
        return $this->product->getWeight();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getLineItem(): LineItemInterface
    {
        return $this->lineItem;
    }

    public function getDelivery(): ? Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): void
    {
        $this->delivery = $delivery;
    }

    public function getRule(): ? Rule
    {
        return $this->rule;
    }

    public function getType(): string
    {
        return $this->lineItem->getType();
    }

    public function getLabel(): string
    {
        return $this->product->getName();
    }

    public function getCover(): ?MediaBasicStruct
    {
        return $this->cover;
    }

    public function getDescription(): ?string
    {
        return $this->product->getDescription();
    }

    public function getExtension(string $name): ?Struct
    {
        if (!$this->hasExtension($name)) {
            return $this->product->getExtension($name);
        }

        return parent::getExtension($name);
    }
}
