<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Dbal\FieldResolver;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Framework\ORM\Dbal\EntityDefinitionQueryHelper;
use Shopware\Framework\ORM\Dbal\QueryBuilder;
use Shopware\Framework\ORM\Field\Field;

class FieldResolverRegistry
{
    /**
     * @var FieldResolverInterface[]
     */
    protected $resolvers;

    public function __construct(iterable $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function resolve(string $definition, string $root, Field $field, QueryBuilder $query, ApplicationContext $context, EntityDefinitionQueryHelper $queryHelper, $raw = false): void
    {
        foreach ($this->resolvers as $resolver) {
            $resolver->resolve($definition, $root, $field, $query, $context, $queryHelper, $raw);
        }
    }
}
