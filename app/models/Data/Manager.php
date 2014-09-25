<?php

namespace Model\Data;

use Model\Data\Source\AbstractSource;
use Model\Data\Filter\AbstractFilter;

class Manager
{

    /**
     * @var AbstractSource
     */
    protected $source;

    /**
     * @var AbstractFilter[]
     */
    protected $filters = [];

    /**
     * @param string $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = AbstractSource::factory($source);
        return $this;
    }

    /**
     * @param AbstractFilter $filter
     * @return $this
     */
    public function addFilter(AbstractFilter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param string $orderField
     * @param string $orderDirection
     * @return array
     */
    public function getData($orderField, $orderDirection = 'asc')
    {
        $data = $this->source->getData();
        $data = $this->applyFilters($data);
        $data = $this->applyOrder($data, $orderField, $orderDirection);
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function applyFilters(array $data)
    {
        foreach ($this->filters as $filter) {
            try {
                $data = $filter->filter($data);
            } catch (\Exception $e) {
                // TODO: add logs
            }
        }
        return $data;
    }

    /**
     * @param array $data
     * @param string $orderField
     * @param string $orderDirection
     * @return array $data
     */
    protected function applyOrder(array $data, $orderField = '', $orderDirection = 'asc')
    {
        $orderField = (string)$orderField;
        if ($orderField) {
            usort($data, function($a, $b) use ($orderField) {
                if (isset($a[$orderField], $b[$orderField])) {
                    if ($a[$orderField] > $b[$orderField]) {
                        return 1;
                    } elseif ($b[$orderField] > $a[$orderField]) {
                        return -1;
                    }
                }
                return 0;
            });
            if ($orderDirection == 'desc') {
                $data = array_reverse($data);
            }
        }
        return $data;
    }

}