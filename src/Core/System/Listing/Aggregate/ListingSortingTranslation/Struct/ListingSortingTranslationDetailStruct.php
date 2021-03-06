<?php declare(strict_types=1);

namespace Shopware\System\Listing\Aggregate\ListingSortingTranslation\Struct;

use Shopware\Application\Language\Struct\LanguageBasicStruct;
use Shopware\System\Listing\Struct\ListingSortingBasicStruct;

class ListingSortingTranslationDetailStruct extends ListingSortingTranslationBasicStruct
{
    /**
     * @var ListingSortingBasicStruct
     */
    protected $listingSorting;

    /**
     * @var LanguageBasicStruct
     */
    protected $language;

    public function getListingSorting(): ListingSortingBasicStruct
    {
        return $this->listingSorting;
    }

    public function setListingSorting(ListingSortingBasicStruct $listingSorting): void
    {
        $this->listingSorting = $listingSorting;
    }

    public function getLanguage(): LanguageBasicStruct
    {
        return $this->language;
    }

    public function setLanguage(LanguageBasicStruct $language): void
    {
        $this->language = $language;
    }
}
