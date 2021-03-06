<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Collection\ConfigurationGroupOptionBasicCollection;
use Shopware\System\Configuration\Event\ConfigurationGroupBasicLoadedEvent;

class ConfigurationGroupOptionBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'configuration_group_option.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ConfigurationGroupOptionBasicCollection
     */
    protected $configurationGroupOptions;

    public function __construct(ConfigurationGroupOptionBasicCollection $configurationGroupOptions, ApplicationContext $context)
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

    public function getConfigurationGroupOptions(): ConfigurationGroupOptionBasicCollection
    {
        return $this->configurationGroupOptions;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configurationGroupOptions->getGroups()->count() > 0) {
            $events[] = new ConfigurationGroupBasicLoadedEvent($this->configurationGroupOptions->getGroups(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
