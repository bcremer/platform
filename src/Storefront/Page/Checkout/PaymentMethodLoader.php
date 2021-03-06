<?php declare(strict_types=1);

namespace Shopware\Storefront\Page\Checkout;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Checkout\Payment\Collection\PaymentMethodBasicCollection;
use Shopware\Checkout\Payment\PaymentMethodRepository;
use Shopware\Framework\ORM\Search\Criteria;
use Shopware\Framework\ORM\Search\Query\TermQuery;
use Symfony\Component\HttpFoundation\Request;

class PaymentMethodLoader
{
    /**
     * @var \Shopware\Checkout\Payment\PaymentMethodRepository
     */
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function load(Request $request, ApplicationContext $context)
    {
        // todo@dr remove request, provide storefront context, provide calculated cart, use context rule system to validate
        $criteria = $this->createCriteria($request);
        $paymentMethods = $this->paymentMethodRepository->search($criteria, $context);

        return new PaymentMethodBasicCollection($paymentMethods->getElements());
    }

    private function createCriteria(Request $request): Criteria
    {
        $limit = $request->query->getInt('limit', 20);
        $page = $request->query->getInt('page', 1);

        $criteria = new Criteria();
        $criteria->setOffset(($page - 1) * $limit);
        $criteria->setLimit($limit);
        $criteria->addFilter(new TermQuery('payment_method.active', 1));
        $criteria->setFetchCount(Criteria::FETCH_COUNT_TOTAL);

        return $criteria;
    }
}
