<?php declare(strict_types=1);

namespace Shopware\System\Mail\Aggregate\MailAttachment\Collection;

use Shopware\Content\Media\Collection\MediaBasicCollection;
use Shopware\System\Mail\Aggregate\MailAttachment\Struct\MailAttachmentDetailStruct;
use Shopware\System\Mail\Collection\MailBasicCollection;
use Shopware\System\Mail\Collection\ShopBasicCollection;

class MailAttachmentDetailCollection extends MailAttachmentBasicCollection
{
    /**
     * @var \Shopware\System\Mail\Aggregate\MailAttachment\Struct\MailAttachmentDetailStruct[]
     */
    protected $elements = [];

    public function getMails(): MailBasicCollection
    {
        return new MailBasicCollection(
            $this->fmap(function (MailAttachmentDetailStruct $mailAttachment) {
                return $mailAttachment->getMail();
            })
        );
    }

    public function getMedia(): MediaBasicCollection
    {
        return new MediaBasicCollection(
            $this->fmap(function (MailAttachmentDetailStruct $mailAttachment) {
                return $mailAttachment->getMedia();
            })
        );
    }

    public function getShops(): ShopBasicCollection
    {
        return new ShopBasicCollection(
            $this->fmap(function (MailAttachmentDetailStruct $mailAttachment) {
                return $mailAttachment->getShop();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return MailAttachmentDetailStruct::class;
    }
}
