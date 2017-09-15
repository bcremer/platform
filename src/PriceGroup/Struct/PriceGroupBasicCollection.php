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

namespace Shopware\PriceGroup\Struct;

use Shopware\Framework\Struct\Collection;

class PriceGroupBasicCollection extends Collection
{
    /**
     * @var PriceGroupBasicStruct[]
     */
    protected $elements = [];

    public function add(PriceGroupBasicStruct $priceGroup): void
    {
        $key = $this->getKey($priceGroup);
        $this->elements[$key] = $priceGroup;
    }

    public function remove(string $uuid): void
    {
        parent::doRemoveByKey($uuid);
    }

    public function removeElement(PriceGroupBasicStruct $priceGroup): void
    {
        parent::doRemoveByKey($this->getKey($priceGroup));
    }

    public function exists(PriceGroupBasicStruct $priceGroup): bool
    {
        return parent::has($this->getKey($priceGroup));
    }

    public function getList(array $uuids): PriceGroupBasicCollection
    {
        return new self(array_intersect_key($this->elements, array_flip($uuids)));
    }

    public function get(string $uuid): ? PriceGroupBasicStruct
    {
        if ($this->has($uuid)) {
            return $this->elements[$uuid];
        }

        return null;
    }

    public function getUuids(): array
    {
        return $this->fmap(function (PriceGroupBasicStruct $priceGroup) {
            return $priceGroup->getUuid();
        });
    }

    protected function getKey(PriceGroupBasicStruct $element): string
    {
        return $element->getUuid();
    }
}