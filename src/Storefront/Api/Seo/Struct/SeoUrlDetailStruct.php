<?php declare(strict_types=1);

namespace Shopware\Storefront\Api\Seo\Struct;

use Shopware\Application\Application\Struct\ApplicationBasicStruct;

class SeoUrlDetailStruct extends SeoUrlBasicStruct
{
    /**
     * @var ApplicationBasicStruct
     */
    protected $application;

    public function getApplication(): ApplicationBasicStruct
    {
        return $this->application;
    }

    public function setApplication(ShopBasicStruct $application): void
    {
        $this->application = $application;
    }
}
