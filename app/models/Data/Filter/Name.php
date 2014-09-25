<?php

namespace Model\Data\Filter;

class Name extends AbstractFilter
{

    /**
     * @param array $data
     * @return array
     */
    public function filter(array $data)
    {
        if ($this->value == '') {
            return $data;
        }
        return array_filter($data, function($a) {
            return stripos($a['name'], $this->value) !== false;
        });
    }

}