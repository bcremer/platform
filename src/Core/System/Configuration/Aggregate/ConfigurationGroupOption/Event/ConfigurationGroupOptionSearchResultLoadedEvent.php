<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Configuration\Aggregate\ConfigurationGroupOption\Struct\ConfigurationGroupOptionSearchResult;

class ConfigurationGroupOptionSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'configuration_group_option.search.result.loaded';

    /**
     * @var ConfigurationGroupOptionSearchResult
     */
    protected $result;

    public function __construct(ConfigurationGroupOptionSearchResult $result)
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
