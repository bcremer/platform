<?php declare(strict_types=1);

namespace Shopware\System\Tax\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\Tax\Collection\TaxBasicCollection;

class TaxBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'tax.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var TaxBasicCollection
     */
    protected $taxes;

    public function __construct(TaxBasicCollection $taxes, ApplicationContext $context)
    {
        $this->context = $context;
        $this->taxes = $taxes;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getTaxes(): TaxBasicCollection
    {
        return $this->taxes;
    }
}
