<?php declare(strict_types=1);

namespace Shopware\System\Tax\Aggregate\TaxAreaRuleTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Tax\Aggregate\TaxAreaRuleTranslation\Collection\TaxAreaRuleTranslationBasicCollection;

class TaxAreaRuleTranslationBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'tax_area_rule_translation.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var TaxAreaRuleTranslationBasicCollection
     */
    protected $taxAreaRuleTranslations;

    public function __construct(TaxAreaRuleTranslationBasicCollection $taxAreaRuleTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->taxAreaRuleTranslations = $taxAreaRuleTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getTaxAreaRuleTranslations(): TaxAreaRuleTranslationBasicCollection
    {
        return $this->taxAreaRuleTranslations;
    }
}
