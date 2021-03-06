<?php declare(strict_types=1);

namespace Shopware\System\User\Event;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\System\User\Struct\UserSearchResult;

class UserSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'user.search.result.loaded';

    /**
     * @var UserSearchResult
     */
    protected $result;

    public function __construct(UserSearchResult $result)
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
