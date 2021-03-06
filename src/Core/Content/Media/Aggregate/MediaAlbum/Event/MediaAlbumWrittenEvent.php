<?php declare(strict_types=1);

namespace Shopware\Content\Media\Aggregate\MediaAlbum\Event;

use Shopware\Content\Media\Aggregate\MediaAlbum\MediaAlbumDefinition;
use Shopware\Framework\ORM\Write\WrittenEvent;

class MediaAlbumWrittenEvent extends WrittenEvent
{
    public const NAME = 'media_album.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return MediaAlbumDefinition::class;
    }
}
