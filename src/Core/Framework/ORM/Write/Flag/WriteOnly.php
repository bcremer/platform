<?php declare(strict_types=1);

namespace Shopware\Framework\ORM\Write\Flag;

/**
 * Fields with this flag can not be read and are not part of any struct of the entity
 */
class WriteOnly extends Flag
{
}
