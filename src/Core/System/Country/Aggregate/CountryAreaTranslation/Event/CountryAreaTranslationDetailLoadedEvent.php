<?php declare(strict_types=1);

namespace Shopware\System\Country\Aggregate\CountryAreaTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Application\Language\Event\LanguageBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Country\Aggregate\CountryArea\Event\CountryAreaBasicLoadedEvent;
use Shopware\System\Country\Aggregate\CountryAreaTranslation\Collection\CountryAreaTranslationDetailCollection;

class CountryAreaTranslationDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'country_area_translation.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var CountryAreaTranslationDetailCollection
     */
    protected $countryAreaTranslations;

    public function __construct(CountryAreaTranslationDetailCollection $countryAreaTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->countryAreaTranslations = $countryAreaTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getCountryAreaTranslations(): CountryAreaTranslationDetailCollection
    {
        return $this->countryAreaTranslations;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->countryAreaTranslations->getCountryAreas()->count() > 0) {
            $events[] = new CountryAreaBasicLoadedEvent($this->countryAreaTranslations->getCountryAreas(), $this->context);
        }
        if ($this->countryAreaTranslations->getLanguages()->count() > 0) {
            $events[] = new LanguageBasicLoadedEvent($this->countryAreaTranslations->getLanguages(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
