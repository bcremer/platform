<?php declare(strict_types=1);

namespace Shopware\System\Config\Aggregate\ConfigFormFieldTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Config\Aggregate\ConfigFormFieldTranslation\Struct\ConfigFormFieldTranslationSearchResult;

class ConfigFormFieldTranslationSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form_field_translation.search.result.loaded';

    /**
     * @var \Shopware\System\Config\Aggregate\ConfigFormFieldTranslation\Struct\ConfigFormFieldTranslationSearchResult
     */
    protected $result;

    public function __construct(ConfigFormFieldTranslationSearchResult $result)
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
