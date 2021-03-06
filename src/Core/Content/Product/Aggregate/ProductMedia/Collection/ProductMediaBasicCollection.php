<?php declare(strict_types=1);

namespace Shopware\Content\Product\Aggregate\ProductMedia\Collection;

use Shopware\Content\Media\Collection\MediaBasicCollection;
use Shopware\Content\Product\Aggregate\ProductMedia\Struct\ProductMediaBasicStruct;
use Shopware\Framework\ORM\EntityCollection;

class ProductMediaBasicCollection extends EntityCollection
{
    /**
     * @var \Shopware\Content\Product\Aggregate\ProductMedia\Struct\ProductMediaBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? ProductMediaBasicStruct
    {
        return parent::get($id);
    }

    public function current(): ProductMediaBasicStruct
    {
        return parent::current();
    }

    public function getProductIds(): array
    {
        return $this->fmap(function (ProductMediaBasicStruct $productMedia) {
            return $productMedia->getProductId();
        });
    }

    public function filterByProductId(string $id): self
    {
        return $this->filter(function (ProductMediaBasicStruct $productMedia) use ($id) {
            return $productMedia->getProductId() === $id;
        });
    }

    public function getMediaIds(): array
    {
        return $this->fmap(function (ProductMediaBasicStruct $productMedia) {
            return $productMedia->getMediaId();
        });
    }

    public function filterByMediaId(string $id): self
    {
        return $this->filter(function (ProductMediaBasicStruct $productMedia) use ($id) {
            return $productMedia->getMediaId() === $id;
        });
    }

    public function getMedia(): MediaBasicCollection
    {
        return new MediaBasicCollection(
            $this->fmap(function (ProductMediaBasicStruct $productMedia) {
                return $productMedia->getMedia();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return ProductMediaBasicStruct::class;
    }
}
