<?php declare(strict_types=1);

namespace Shopware\Content\Catalog\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Catalog\Struct\CatalogSearchResult;
use Shopware\Framework\Event\NestedEvent;

class CatalogSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'catalog.search.result.loaded';

    /**
     * @var CatalogSearchResult
     */
    protected $result;

    public function __construct(CatalogSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->result->getContext();
    }
}
