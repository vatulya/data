<?php

namespace Controller;

use Model\Data\Manager as DataManager;
use Model\Data\Filter\AbstractFilter;

class Index extends AbstractController
{

    public function indexAction()
    {

    }

    public function dataAction()
    {
        $dataManager = new DataManager();
        $dataManager->setSource(getArrayValue($_REQUEST, 'source', 'php'));
        $filters = getArrayValue($_REQUEST, 'filter');
        if ($filters) {
            if (is_array($filters)) {
                foreach ($filters as $filterName => $filterValue) {
                    $dataManager->addFilter(AbstractFilter::factory($filterName, $filterValue));
                }
            }
        }
        $order = getArrayValue($_REQUEST, 'order', []);
        $orderField = getArrayValue($order, 'field');
        $orderDirection = getArrayValue($order, 'direction');
        $data = $dataManager->getData($orderField, $orderDirection);
        $this->view['data'] = $data;
        $this->view['order'] = [
            'field' => $orderField,
            'direction' => $orderDirection,
        ];
    }

}