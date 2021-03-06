<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Dbal\Indexing;

use Doctrine\DBAL\Connection;
use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Product\ProductRepository;
use Shopware\Framework\Event\ProgressAdvancedEvent;
use Shopware\Framework\Event\ProgressFinishedEvent;
use Shopware\Framework\Event\ProgressStartedEvent;
use Shopware\Framework\ORM\Dbal\Common\EventIdExtractor;
use Shopware\Framework\ORM\Dbal\Common\LastIdQuery;
use Shopware\Framework\ORM\Write\GenericWrittenEvent;
use Shopware\Framework\Struct\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class VariationJsonIndexer implements IndexerInterface
{
    /**
     * @var \Shopware\Content\Product\ProductRepository
     */
    private $productRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var EventIdExtractor
     */
    private $eventIdExtractor;

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(
        ProductRepository $productRepository,
        EventDispatcherInterface $eventDispatcher,
        EventIdExtractor $eventIdExtractor,
        Connection $connection
    ) {
        $this->productRepository = $productRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->eventIdExtractor = $eventIdExtractor;
        $this->connection = $connection;
    }

    public function index(\DateTime $timestamp, string $tenantId): void
    {
        $context = ApplicationContext::createDefaultContext($tenantId);

        $iterator = $this->createIterator($tenantId);

        $this->eventDispatcher->dispatch(
            ProgressStartedEvent::NAME,
            new ProgressStartedEvent('Start indexing variations', $iterator->fetchCount())
        );

        while ($ids = $iterator->fetch()) {
            $ids = array_map(function ($id) {
                return Uuid::fromBytesToHex($id);
            }, $ids);

            $this->update($ids, $context);

            $this->eventDispatcher->dispatch(
                ProgressAdvancedEvent::NAME,
                new ProgressAdvancedEvent(count($ids))
            );
        }

        $this->eventDispatcher->dispatch(
            ProgressFinishedEvent::NAME,
            new ProgressFinishedEvent('Finished indexing variations')
        );
    }

    public function refresh(GenericWrittenEvent $event): void
    {
        $ids = $this->eventIdExtractor->getProductIds($event);

        $this->update($ids, $event->getContext());
    }

    private function update(array $productIds, ApplicationContext $context)
    {
        if (empty($productIds)) {
            return;
        }

        $sql = <<<SQL
UPDATE product, product_variation SET product.variation_ids = (
    SELECT CONCAT('[', GROUP_CONCAT(JSON_QUOTE(LOWER(HEX(product_variation.configuration_group_option_id)))), ']')
    FROM product_variation
    WHERE product_variation.product_id = product.id
    AND product_variation.product_tenant_id = :tenant
)
WHERE product_variation.product_id = product.id
AND product.tenant_id = :tenant
AND product.id IN (:ids)
SQL;

        $tenantId = Uuid::fromHexToBytes($context->getTenantId());

        $bytes = array_map(function ($id) {
            return Uuid::fromStringToBytes($id);
        }, $productIds);

        $this->connection->executeUpdate(
            $sql,
            ['ids' => $bytes, 'tenant' => $tenantId],
            ['ids' => Connection::PARAM_STR_ARRAY]
        );
    }

    private function createIterator(string $tenantId): LastIdQuery
    {
        $query = $this->connection->createQueryBuilder();
        $query->select(['product.auto_increment', 'product.id']);
        $query->from('product');
        $query->andWhere('product.tenant_id = :tenantId');
        $query->andWhere('product.auto_increment > :lastId');
        $query->addOrderBy('product.auto_increment');

        $query->setMaxResults(50);

        $query->setParameter('tenantId', Uuid::fromHexToBytes($tenantId));
        $query->setParameter('lastId', 0);

        return new LastIdQuery($query);
    }
}
