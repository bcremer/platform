<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Collection\ConfigurationGroupOptionDetailCollection;
use Shopware\System\Configuration\Aggregate\ConfigurationGroupOptionTranslation\Event\ConfigurationGroupOptionTranslationBasicLoadedEvent;
use Shopware\System\Configuration\Event\ConfigurationGroupBasicLoadedEvent;

class ConfigurationGroupOptionDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'configuration_group_option.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ConfigurationGroupOptionDetailCollection
     */
    protected $configurationGroupOptions;

    public function __construct(ConfigurationGroupOptionDetailCollection $configurationGroupOptions, ApplicationContext $context)
    {
        $this->context = $context;
        $this->configurationGroupOptions = $configurationGroupOptions;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getConfigurationGroupOptions(): ConfigurationGroupOptionDetailCollection
    {
        return $this->configurationGroupOptions;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configurationGroupOptions->getGroups()->count() > 0) {
            $events[] = new ConfigurationGroupBasicLoadedEvent($this->configurationGroupOptions->getGroups(), $this->context);
        }
        if ($this->configurationGroupOptions->getTranslations()->count() > 0) {
            $events[] = new ConfigurationGroupOptionTranslationBasicLoadedEvent($this->configurationGroupOptions->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
