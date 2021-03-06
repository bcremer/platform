<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Dbal\Indexing\Analyzer;

use Shopware\Application\Context\Struct\ApplicationContext;
use Shopware\Content\Product\Struct\ProductBasicStruct;

class SearchAnalyzerRegistry
{
    /**
     * @var SearchAnalyzerInterface[]
     */
    protected $analyzers;

    public function __construct(iterable $analyzers)
    {
        $this->analyzers = $analyzers;
    }

    public function analyze(ProductBasicStruct $product, ApplicationContext $context): array
    {
        $collection = [];

        foreach ($this->analyzers as $analyzer) {
            $keywords = $analyzer->analyze($product, $context);

            foreach ($keywords as $keyword => $ranking) {
                $before = 0;

                if (array_key_exists($keyword, $collection)) {
                    $before = $collection[$keyword];
                }

                $collection[$keyword] = max($before, $ranking);
            }
        }

        return $collection;
    }
}
