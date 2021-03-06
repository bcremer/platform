<?php declare(strict_types=1);

namespace Shopware\System\Config\Aggregate\ConfigFormFieldTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Config\Aggregate\ConfigFormField\Event\ConfigFormFieldBasicLoadedEvent;
use Shopware\System\Config\Aggregate\ConfigFormFieldTranslation\Collection\ConfigFormFieldTranslationDetailCollection;
use Shopware\System\Locale\Event\LocaleBasicLoadedEvent;

class ConfigFormFieldTranslationDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form_field_translation.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ConfigFormFieldTranslationDetailCollection
     */
    protected $configFormFieldTranslations;

    public function __construct(ConfigFormFieldTranslationDetailCollection $configFormFieldTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->configFormFieldTranslations = $configFormFieldTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getConfigFormFieldTranslations(): ConfigFormFieldTranslationDetailCollection
    {
        return $this->configFormFieldTranslations;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configFormFieldTranslations->getConfigFormFields()->count() > 0) {
            $events[] = new ConfigFormFieldBasicLoadedEvent($this->configFormFieldTranslations->getConfigFormFields(), $this->context);
        }
        if ($this->configFormFieldTranslations->getLocales()->count() > 0) {
            $events[] = new LocaleBasicLoadedEvent($this->configFormFieldTranslations->getLocales(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
