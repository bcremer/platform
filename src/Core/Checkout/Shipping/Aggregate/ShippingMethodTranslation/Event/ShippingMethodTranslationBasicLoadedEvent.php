<?php declare(strict_types=1);

namespace Shopware\Checkout\Shipping\Aggregate\ShippingMethodTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Shipping\Aggregate\ShippingMethodTranslation\Collection\ShippingMethodTranslationBasicCollection;
use Shopware\Framework\Event\NestedEvent;

class ShippingMethodTranslationBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'shipping_method_translation.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var ShippingMethodTranslationBasicCollection
     */
    protected $shippingMethodTranslations;

    public function __construct(ShippingMethodTranslationBasicCollection $shippingMethodTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->shippingMethodTranslations = $shippingMethodTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getShippingMethodTranslations(): ShippingMethodTranslationBasicCollection
    {
        return $this->shippingMethodTranslations;
    }
}
