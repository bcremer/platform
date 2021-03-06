<?php declare(strict_types=1);

namespace Shopware\Content\Media\Extension;

use Shopware\Content\Media\Event\MediaBasicLoadedEvent;
use Shopware\Content\Media\Util\UrlGeneratorInterface;
use Shopware\Framework\Struct\ArrayStruct;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UrlExtension implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            MediaBasicLoadedEvent::NAME => 'mediaLoaded',
        ];
    }

    public function mediaLoaded(MediaBasicLoadedEvent $event): void
    {
        foreach ($event->getMedia() as $media) {
            $media->addExtension('links', new ArrayStruct([
                'url' => $this->urlGenerator->getUrl($media->getFileName()),
            ]));
        }
    }
}
