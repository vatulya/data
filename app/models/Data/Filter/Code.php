<?php

namespace Model\Data\Filter;

class Code extends AbstractFilter
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
            if (!is_array($a) || !array_key_exists('code', $a)) {
                return false;
            }
            return strtolower($a['code']) == strtolower($this->value);
        });
    }

}