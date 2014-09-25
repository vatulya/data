<?php

namespace Model\Data\Filter;

class Group extends AbstractFilter
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
            return strtolower($a['group']) == strtolower($this->value);
        });
    }

}