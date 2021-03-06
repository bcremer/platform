<?php declare(strict_types=1);

namespace Shopware\Framework\Api\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Shopware\Framework\Api\Context\RestContext;
use Shopware\Framework\ORM\DefinitionRegistry;
use Shopware\Framework\ORM\RepositoryInterface;
use Shopware\Framework\ORM\Write\FieldException\WriteStackException;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route(service="Shopware\Framework\Api\Controller\SyncController", path="/api/sync")
 */
class SyncController extends Controller
{
    public const ACTION_UPSERT = 'upsert';
    public const ACTION_DELETE = 'delete';

    /**
     * @var DefinitionRegistry
     */
    protected $registry;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(DefinitionRegistry $registry, ContainerInterface $container, Serializer $serializer)
    {
        $this->registry = $registry;
        $this->container = $container;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", name="sync.api")
     * @Method({"POST"})
     *
     * @param Request                                     $request
     * @param \Shopware\Framework\Api\Context\RestContext $restContext
     *
     * @return Response
     */
    public function sync(Request $request, RestContext $restContext): Response
    {
        $payload = $this->serializer->decode($request->getContent(), 'json');

        $context = $restContext->getApplicationContext();

        $errors = $result = [];

        foreach ($payload as $operation) {
            $action = $operation['action'];
            $entity = $operation['entity'];

            $definition = $this->registry->get($entity);

            /** @var RepositoryInterface $repository */
            $repository = $this->container->get($definition::getRepositoryClass());

            switch ($action) {
                case self::ACTION_DELETE:
                    /** @var WrittenEvent $event */
                    $generic = $repository->delete([$operation['payload']], $context);

                    $errors = array_merge($errors, $generic->getErrors());

                    break;

                case self::ACTION_UPSERT:
                    try {
                        /** @var WrittenEvent $event */
                        $generic = $repository->upsert(
                            [$operation['payload']],
                            $context
                        );

                        foreach ($generic->getEvents() as $event) {
                            $eventDefinition = $event->getDefinition();

                            if (array_key_exists($eventDefinition, $result)) {
                                $result[$eventDefinition]['ids'] = array_merge(
                                    $result[$eventDefinition]['ids'],
                                    $event->getIds()
                                );
                            } else {
                                $result[$eventDefinition] = [
                                    'definition' => $eventDefinition,
                                    'ids' => $event->getIds(),
                                ];
                            }

                            $errors = array_merge($errors, $event->getErrors());
                        }
                    } catch (WriteStackException $exception) {
                        $errors = array_merge($errors, $exception->toArray());
                    }

                    break;
            }
        }

        $result = array_values($result);

        $response = [
            'data' => $result,
            'errors' => $errors,
        ];

        return new JsonResponse($response);
    }
}
