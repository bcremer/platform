<?php declare(strict_types=1);

namespace Shopware\System\Tax\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Tax\Struct\TaxSearchResult;

class TaxSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'tax.search.result.loaded';

    /**
     * @var TaxSearchResult
     */
    protected $result;

    public function __construct(TaxSearchResult $result)
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
