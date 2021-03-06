<?php declare(strict_types=1);

namespace Shopware\System\Listing\Aggregate\ListingFacetTranslation\Collection;

use Shopware\Application\Language\Collection\LanguageBasicCollection;
use Shopware\System\Listing\Aggregate\ListingFacetTranslation\Struct\ListingFacetTranslationDetailStruct;
use Shopware\System\Listing\Collection\ListingFacetBasicCollection;

class ListingFacetTranslationDetailCollection extends ListingFacetTranslationBasicCollection
{
    /**
     * @var ListingFacetTranslationDetailStruct[]
     */
    protected $elements = [];

    public function getListingFacets(): ListingFacetBasicCollection
    {
        return new ListingFacetBasicCollection(
            $this->fmap(function (ListingFacetTranslationDetailStruct $listingFacetTranslation) {
                return $listingFacetTranslation->getListingFacet();
            })
        );
    }

    public function getLanguages(): LanguageBasicCollection
    {
        return new LanguageBasicCollection(
            $this->fmap(function (ListingFacetTranslationDetailStruct $listingFacetTranslation) {
                return $listingFacetTranslation->getLanguage();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return ListingFacetTranslationDetailStruct::class;
    }
}
