<?php declare(strict_types=1);
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Framework\ORM\Field;

use Shopware\Framework\ORM\Write\DataStack\KeyValuePair;
use Shopware\Framework\ORM\Write\EntityExistence;
use Shopware\Framework\ORM\Write\FieldAware\StorageAware;
use Shopware\Framework\ORM\Write\FieldException\InvalidFieldException;
use Shopware\Framework\ORM\Write\ValueTransformer\ValueTransformer;
use Shopware\Framework\ORM\Write\ValueTransformer\ValueTransformerDate;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class DateField extends Field implements StorageAware
{
    /**
     * @var string
     */
    private $storageName;

    public function __construct(string $storageName, string $propertyName)
    {
        $this->storageName = $storageName;
        parent::__construct($propertyName);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(EntityExistence $existence, KeyValuePair $data): \Generator
    {
        $key = $data->getKey();
        $value = $data->getValue();

        if ($existence->exists()) {
            $this->validate($this->getUpdateConstraints(), $key, $value);
        }

        yield $this->storageName => $this->getValueTransformer()->transform($value);
    }

    public function getStorageName(): string
    {
        return $this->storageName;
    }

    /**
     * @param array  $constraints
     * @param string $fieldName
     * @param $value
     */
    private function validate(array $constraints, string $fieldName, $value)
    {
        $violationList = new ConstraintViolationList();

        foreach ($constraints as $constraint) {
            $violations = $this->validator
                ->validate($value, $constraint);

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $violationList->add(
                    new ConstraintViolation(
                        $violation->getMessage(),
                        $violation->getMessageTemplate(),
                        $violation->getParameters(),
                        $violation->getRoot(),
                        $fieldName,
                        $violation->getInvalidValue(),
                        $violation->getPlural(),
                        $violation->getCode(),
                        $violation->getConstraint(),
                        $violation->getCause()
                    )
                );
            }
        }

        if (count($violationList)) {
            throw new InvalidFieldException($this->path . '/' . $fieldName, $violationList);
        }
    }

    /**
     * @return array
     */
    private function getInsertConstraints(): array
    {
        return $this->constraintBuilder
            ->isNotBlank()
            ->isDate()
            ->getConstraints();
    }

    /**
     * @return array
     */
    private function getUpdateConstraints(): array
    {
        return $this->constraintBuilder
            ->isDate()
            ->getConstraints();
    }

    /**
     * @return ValueTransformer
     */
    private function getValueTransformer(): ValueTransformer
    {
        return $this->valueTransformerRegistry
            ->get(ValueTransformerDate::class);
    }
}
