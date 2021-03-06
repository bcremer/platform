<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Field;

use Shopware\Framework\ORM\Write\DataStack\KeyValuePair;
use Shopware\Framework\ORM\Write\EntityExistence;
use Shopware\Framework\ORM\Write\Flag\Deferred;
use Shopware\Framework\ORM\Write\Flag\ReadOnly;

class StructField extends Field implements AssociationInterface
{
    /**
     * @var bool
     */
    private $inBasic;

    /**
     * @var string
     */
    private $structClass;

    public function __construct(string $propertyName, string $structClass, bool $inBasic)
    {
        parent::__construct($propertyName);
        $this->inBasic = $inBasic;
        $this->structClass = $structClass;
        $this->setFlags(new ReadOnly(), new Deferred());
    }

    public function __invoke(EntityExistence $existence, KeyValuePair $data): \Generator
    {
        throw new \Exception('Struct fields can be invoked in write context');
    }

    public function loadInBasic(): bool
    {
        return $this->inBasic;
    }

    public function getReferenceClass(): string
    {
        return $this->structClass;
    }
}
