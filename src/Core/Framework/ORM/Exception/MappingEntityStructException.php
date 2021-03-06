<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Exception;

use Shopware\Framework\ShopwareException;
use Throwable;

class MappingEntityStructException extends \RuntimeException implements ShopwareException
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        $message = 'Mapping definition neither have structs nor collection.';

        parent::__construct($message, $code, $previous);
    }
}
