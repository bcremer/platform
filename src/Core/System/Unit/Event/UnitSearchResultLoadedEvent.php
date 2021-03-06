<?php declare(strict_types=1);

namespace Shopware\System\Unit\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Unit\Struct\UnitSearchResult;

class UnitSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'unit.search.result.loaded';

    /**
     * @var UnitSearchResult
     */
    protected $result;

    public function __construct(UnitSearchResult $result)
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
