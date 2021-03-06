<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Collection;

use Shopware\Framework\ORM\EntityCollection;
use Shopware\System\Configuration\Struct\ConfigurationGroupBasicStruct;

class ConfigurationGroupBasicCollection extends EntityCollection
{
    /**
     * @var ConfigurationGroupBasicStruct[]
     */
    protected $elements = [];

    public function get(string $id): ? ConfigurationGroupBasicStruct
    {
        return parent::get($id);
    }

    public function current(): ConfigurationGroupBasicStruct
    {
        return parent::current();
    }

    protected function getExpectedClass(): string
    {
        return ConfigurationGroupBasicStruct::class;
    }
}
