<?php declare(strict_types=1);

namespace Shopware\Content\Category\Aggregate\CategoryTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Application\Language\Event\LanguageBasicLoadedEvent;
use Shopware\Content\Category\Aggregate\CategoryTranslation\Collection\CategoryTranslationDetailCollection;
use Shopware\Content\Category\Event\CategoryBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class CategoryTranslationDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'category_translation.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var CategoryTranslationDetailCollection
     */
    protected $categoryTranslations;

    public function __construct(CategoryTranslationDetailCollection $categoryTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->categoryTranslations = $categoryTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getCategoryTranslations(): CategoryTranslationDetailCollection
    {
        return $this->categoryTranslations;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->categoryTranslations->getCategories()->count() > 0) {
            $events[] = new CategoryBasicLoadedEvent($this->categoryTranslations->getCategories(), $this->context);
        }
        if ($this->categoryTranslations->getLanguages()->count() > 0) {
            $events[] = new LanguageBasicLoadedEvent($this->categoryTranslations->getLanguages(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
