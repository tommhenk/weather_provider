<?php

declare(strict_types=1);

namespace Weather\Provider\Model\Config\Backend\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Weather\Provider\Model\Config\CronConfig;
use Weather\Provider\Provider\ConfigProvider;

/**
 * class Disable
 */
class Disable extends \Magento\Config\Block\System\Config\Form\Field
{
    private ConfigProvider $configProvider;

    /**
     * @param Context $context
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ConfigProvider $configProvider,
        Context $context,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct(
            $context,
            $data,
            $secureRenderer
        );
        $this->configProvider = $configProvider;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element): string
    {
        if (CronConfig::VALUE_FREQUENCY_DAY != $this->configProvider->getFrequencyDay()) {
            $element->setData('readonly', 1);
        }
        return parent::_getElementHtml($element);
    }
}
