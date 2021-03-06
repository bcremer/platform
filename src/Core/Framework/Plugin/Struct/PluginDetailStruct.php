<?php declare(strict_types=1);

namespace Shopware\Framework\Plugin\Struct;

use Shopware\Checkout\Payment\Collection\PaymentMethodBasicCollection;
use Shopware\System\Config\Collection\ConfigFormBasicCollection;

class PluginDetailStruct extends PluginBasicStruct
{
    /**
     * @var ConfigFormBasicCollection
     */
    protected $configForms;

    /**
     * @var PaymentMethodBasicCollection
     */
    protected $paymentMethods;

    public function __construct()
    {
        $this->configForms = new ConfigFormBasicCollection();

        $this->paymentMethods = new PaymentMethodBasicCollection();

        $this->shopTemplates = new ShopTemplateBasicCollection();
    }

    public function getConfigForms(): ConfigFormBasicCollection
    {
        return $this->configForms;
    }

    public function setConfigForms(ConfigFormBasicCollection $configForms): void
    {
        $this->configForms = $configForms;
    }

    public function getPaymentMethods(): PaymentMethodBasicCollection
    {
        return $this->paymentMethods;
    }

    public function setPaymentMethods(PaymentMethodBasicCollection $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }
}
