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
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data);
        }
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