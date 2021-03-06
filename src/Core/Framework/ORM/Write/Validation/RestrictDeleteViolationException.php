<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Write\Validation;

use Shopware\Framework\ORM\EntityDefinition;
use Shopware\Framework\ShopwareException;

class RestrictDeleteViolationException extends \DomainException implements ShopwareException
{
    /**
     * @var RestrictDeleteViolation[]
     */
    protected $restrictions;

    /**
     * @var string|EntityDefinition
     */
    protected $definition;

    public function __construct(string $definition, array $restrictions)
    {
        $this->restrictions = $restrictions;
        parent::__construct('Delete of entities restricted', 400);
        $this->definition = $definition;
    }

    /**
     * @return RestrictDeleteViolation[]
     */
    public function getRestrictions(): array
    {
        return $this->restrictions;
    }
}
