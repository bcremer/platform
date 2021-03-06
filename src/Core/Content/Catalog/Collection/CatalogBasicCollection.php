<?php declare(strict_types=1);

namespace Shopware\Content\Catalog\Collection;

use Shopware\Content\Catalog\Struct\CatalogBasicStruct;
use Shopware\Framework\ORM\EntityCollection;

class CatalogBasicCollection extends EntityCollection
{
    /**
     * @var CatalogBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? CatalogBasicStruct
    {
        return parent::get($id);
    }

    public function current(): CatalogBasicStruct
    {
        return parent::current();
    }

    protected function getExpectedClass(): string
    {
        return CatalogBasicStruct::class;
    }
}
