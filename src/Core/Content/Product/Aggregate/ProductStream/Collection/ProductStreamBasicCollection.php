<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductStream\Collection;

use Shopware\Content\Product\Aggregate\ProductStream\Struct\ProductStreamBasicStruct;
use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Listing\Collection\ListingSortingBasicCollection;

class ProductStreamBasicCollection extends EntityCollection
{
    /**
     * @var \Shopware\Content\Product\Aggregate\ProductStream\Struct\ProductStreamBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? ProductStreamBasicStruct
    {
        return parent::get($id);
    }

    public function current(): ProductStreamBasicStruct
    {
        return parent::current();
    }

    public function getListingSortingIds(): array
    {
        return $this->fmap(function (ProductStreamBasicStruct $productStream) {
            return $productStream->getListingSortingId();
        });
    }

    public function filterByListingSortingId(string $id): self
    {
        return $this->filter(function (ProductStreamBasicStruct $productStream) use ($id) {
            return $productStream->getListingSortingId() === $id;
        });
    }

    public function getListingSortings(): ListingSortingBasicCollection
    {
        return new ListingSortingBasicCollection(
            $this->fmap(function (ProductStreamBasicStruct $productStream) {
                return $productStream->getListingSorting();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return ProductStreamBasicStruct::class;
    }
}
