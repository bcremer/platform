<?php declare(strict_types=1);

namespace Shopware\Content\Category\Util\Tree;

use Shopware\Content\Category\Collection\CategoryBasicCollection;
use Shopware\Content\Category\Struct\CategoryBasicStruct;

class TreeBuilder
{
    /**
     * @param null|string             $parentId
     * @param CategoryBasicCollection $categories
     *
     * @return TreeItem[]
     */
    public static function buildTree(?string $parentId, CategoryBasicCollection $categories): array
    {
        $result = [];
        /** @var CategoryBasicStruct $category */
        foreach ($categories->getElements() as $category) {
            if ($category->getParentId() !== $parentId) {
                continue;
            }

            $result[] = new TreeItem(
                $category,
                self::buildTree($category->getId(), $categories)
            );
        }

        return $result;
    }
}
