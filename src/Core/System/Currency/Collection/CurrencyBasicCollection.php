<?php declare(strict_types=1);

namespace Shopware\System\Currency\Collection;

use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Currency\Struct\CurrencyBasicStruct;

class CurrencyBasicCollection extends EntityCollection
{
    /**
     * @var CurrencyBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? CurrencyBasicStruct
    {
        return parent::get($id);
    }

    public function current(): CurrencyBasicStruct
    {
        return parent::current();
    }

    protected function getExpectedClass(): string
    {
        return CurrencyBasicStruct::class;
    }
}
