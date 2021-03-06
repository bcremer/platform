<?php declare(strict_types=1);

namespace Shopware\System\Mail\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Order\Aggregate\OrderState\Event\OrderStateBasicLoadedEvent;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\System\Mail\Aggregate\MailAttachment\Event\MailAttachmentBasicLoadedEvent;
use Shopware\System\Mail\Aggregate\MailTranslation\Event\MailTranslationBasicLoadedEvent;
use Shopware\System\Mail\Collection\MailDetailCollection;

class MailDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'mail.detail.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var MailDetailCollection
     */
    protected $mails;

    public function __construct(MailDetailCollection $mails, ApplicationContext $context)
    {
        $this->context = $context;
        $this->mails = $mails;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getMails(): MailDetailCollection
    {
        return $this->mails;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->mails->getOrderStates()->count() > 0) {
            $events[] = new OrderStateBasicLoadedEvent($this->mails->getOrderStates(), $this->context);
        }
        if ($this->mails->getAttachments()->count() > 0) {
            $events[] = new MailAttachmentBasicLoadedEvent($this->mails->getAttachments(), $this->context);
        }
        if ($this->mails->getTranslations()->count() > 0) {
            $events[] = new MailTranslationBasicLoadedEvent($this->mails->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
