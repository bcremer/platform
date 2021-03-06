<?php declare(strict_types=1);

namespace Shopware\System\Listing\Collection;

use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Listing\Struct\ListingSortingBasicStruct;

class ListingSortingBasicCollection extends EntityCollection
{
    /**
     * @var ListingSortingBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? ListingSortingBasicStruct
    {
        return parent::get($id);
    }

    public function current(): ListingSortingBasicStruct
    {
        return parent::current();
    }

    protected function getExpectedClass(): string
    {
        return ListingSortingBasicStruct::class;
    }
}
