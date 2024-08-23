<?php

namespace Commerce365\Customer\Block\Adminhtml\Edit\Tab;

use Commerce365\Customer\Block\Adminhtml\CustomerAttributeList;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

class CustomerAttributes extends Generic implements TabInterface
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    public function getTabLabel(): Phrase
    {
        return __('Commerce 365 label');
    }

    public function getTabTitle(): Phrase
    {
        return __('Commerce 365');
    }

    public function canShowTab(): bool
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }
    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass(): string
    {
        return '';
    }
    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl(): string
    {
        return '';
    }
    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded(): bool
    {
        return false;
    }

    protected function _toHtml(): string
    {
        if ($this->canShowTab()) {
            return $this->getFormHtml();
        }

        return '';
    }

    public function getFormHtml(): string
    {
        return $this->getLayout()
          ->createBlock(CustomerAttributeList::class)
          ->setTemplate('Commerce365_Customer::tab/view/customer_attribute_list.phtml')
          ->toHtml();
    }
}
