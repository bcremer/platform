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

namespace Shopware\Checkout\Cart\Price\Struct;

use Shopware\Checkout\Cart\Tax\Struct\CalculatedTaxCollection;
use Shopware\Checkout\Cart\Tax\Struct\TaxRuleCollection;
use Shopware\Framework\Struct\Struct;

class CartPrice extends Struct
{
    public const TAX_STATE_GROSS = 'gross';
    public const TAX_STATE_NET = 'net';
    public const TAX_STATE_FREE = 'tax-free';

    /**
     * @var float
     */
    protected $netPrice;

    /**
     * @var float
     */
    protected $totalPrice;

    /**
     * @var CalculatedTaxCollection
     */
    protected $calculatedTaxes;

    /**
     * @var TaxRuleCollection
     */
    protected $taxRules;

    /**
     * @var float
     */
    protected $positionPrice;

    /**
     * @var string
     */
    protected $taxStatus;

    public function __construct(
        float $netPrice,
        float $totalPrice,
        float $positionPrice,
        CalculatedTaxCollection $calculatedTaxes,
        TaxRuleCollection $taxRules,
        string $taxStatus
    ) {
        $this->netPrice = $netPrice;
        $this->totalPrice = $totalPrice;
        $this->calculatedTaxes = $calculatedTaxes;
        $this->taxRules = $taxRules;
        $this->positionPrice = $positionPrice;
        $this->taxStatus = $taxStatus;
    }

    public function getNetPrice(): float
    {
        return $this->netPrice;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getCalculatedTaxes(): CalculatedTaxCollection
    {
        return $this->calculatedTaxes;
    }

    public function getTaxRules(): TaxRuleCollection
    {
        return $this->taxRules;
    }

    public function getPositionPrice(): float
    {
        return $this->positionPrice;
    }

    public function getTaxStatus(): string
    {
        return $this->taxStatus;
    }

    public function hasNetPrices(): bool
    {
        return \in_array($this->taxStatus, [self::TAX_STATE_NET, self::TAX_STATE_FREE], true);
    }

    public function isTaxFree(): bool
    {
        return $this->taxStatus === self::TAX_STATE_FREE;
    }

    public static function createEmpty(string $taxState = self::TAX_STATE_GROSS)
    {
        return new self(0, 0, 0, new CalculatedTaxCollection(), new TaxRuleCollection(), $taxState);
    }
}
