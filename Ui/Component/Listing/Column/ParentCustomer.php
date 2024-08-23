<?php

namespace Commerce365\Customer\Ui\Component\Listing\Column;

use Commerce365\Customer\Model\Command\GetCustomerEmailById;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ParentCustomer extends Column
{
    private GetCustomerEmailById $getCustomerEmailById;
    private UrlInterface $url;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        GetCustomerEmailById $getCustomerEmailById,
        UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->getCustomerEmailById = $getCustomerEmailById;
        $this->url = $url;
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item)
            {
                if (empty($item['parent_customer_id'])) {
                    continue;
                }
                $email = $this->getCustomerEmailById->execute($item['parent_customer_id']);
                if (!$email) {
                    continue;
                }

                $url = $this->url->getUrl('customer/index/edit', ['id' => $item['parent_customer_id']]);
                $item[$this->getData('name')] = '<a href="' . $url . '">' . $email . '</a>';
            }
        }
        return $dataSource;
    }
}
