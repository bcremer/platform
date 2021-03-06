<?php declare(strict_types=1);

namespace Shopware\System\Listing\Aggregate\ListingFacetTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Listing\Aggregate\ListingFacetTranslation\Struct\ListingFacetTranslationSearchResult;

class ListingFacetTranslationSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'listing_facet_translation.search.result.loaded';

    /**
     * @var ListingFacetTranslationSearchResult
     */
    protected $result;

    public function __construct(ListingFacetTranslationSearchResult $result)
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
