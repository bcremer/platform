<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Version\Event\VersionCommitData;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\ORM\Version\Collection\VersionCommitDataBasicCollection;

class VersionCommitDataBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'version_commit_data.basic.loaded';

    /**
     * @var ApplicationContext
     */
    protected $context;

    /**
     * @var VersionCommitDataBasicCollection
     */
    protected $versionChanges;

    public function __construct(VersionCommitDataBasicCollection $versionChanges, ApplicationContext $context)
    {
        $this->context = $context;
        $this->versionChanges = $versionChanges;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->context;
    }

    public function getVersionChanges(): VersionCommitDataBasicCollection
    {
        return $this->versionChanges;
    }
}
