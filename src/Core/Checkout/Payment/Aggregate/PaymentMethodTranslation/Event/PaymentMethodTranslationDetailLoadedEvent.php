<?php declare(strict_types=1);

namespace Shopware\Checkout\Payment\Aggregate\PaymentMethodTranslation\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Application\Language\Event\LanguageBasicLoadedEvent;
use Shopware\Checkout\Payment\Aggregate\PaymentMethodTranslation\Collection\PaymentMethodTranslationDetailCollection;
use Shopware\Checkout\Payment\Event\PaymentMethodBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class PaymentMethodTranslationDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'payment_method_translation.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var PaymentMethodTranslationDetailCollection
     */
    protected $paymentMethodTranslations;

    public function __construct(PaymentMethodTranslationDetailCollection $paymentMethodTranslations, ApplicationContext $context)
    {
        $this->context = $context;
        $this->paymentMethodTranslations = $paymentMethodTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getPaymentMethodTranslations(): PaymentMethodTranslationDetailCollection
    {
        return $this->paymentMethodTranslations;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->paymentMethodTranslations->getPaymentMethods()->count() > 0) {
            $events[] = new PaymentMethodBasicLoadedEvent($this->paymentMethodTranslations->getPaymentMethods(), $this->context);
        }
        if ($this->paymentMethodTranslations->getLanguages()->count() > 0) {
            $events[] = new LanguageBasicLoadedEvent($this->paymentMethodTranslations->getLanguages(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
