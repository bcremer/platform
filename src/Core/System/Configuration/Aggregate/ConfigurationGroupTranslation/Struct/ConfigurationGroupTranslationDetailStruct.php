<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Aggregate\ConfigurationGroupTranslation\Struct;

use Shopware\Application\Language\Struct\LanguageBasicStruct;
use Shopware\System\Configuration\Struct\ConfigurationGroupBasicStruct;

class ConfigurationGroupTranslationDetailStruct extends ConfigurationGroupTranslationBasicStruct
{
    /**
     * @var ConfigurationGroupBasicStruct
     */
    protected $configurationGroup;

    /**
     * @var LanguageBasicStruct
     */
    protected $language;

    public function getConfigurationGroup(): ConfigurationGroupBasicStruct
    {
        return $this->configurationGroup;
    }

    public function setConfigurationGroup(ConfigurationGroupBasicStruct $configurationGroup): void
    {
        $this->configurationGroup = $configurationGroup;
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
