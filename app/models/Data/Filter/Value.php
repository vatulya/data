<?php

namespace Model\Data\Filter;

class Value extends AbstractFilter
{

    protected $rangeMin;

    protected $rangeMax;

    public function setValue($value)
    {
        if (strpos($value, ' - ') !== false) {
            list($this->rangeMin, $this->rangeMax) = explode(' - ', $value);
            $this->rangeMin = (float)$this->rangeMin;
            $this->rangeMax = (float)$this->rangeMax;
            if ($this->rangeMin < 0) {
                $this->rangeMin = 0;
            }
            if ($this->rangeMax < 0 || $this->rangeMax < $this->rangeMin) {
                $this->rangeMax = 0;
            }
            $this->value = null;
        } else {
            $this->value = (float)$value;
            if ($this->value < 0) {
                $this->value = 0;
            }
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function filter(array $data)
    {
        if (!$this->value && !$this->rangeMin && !$this->rangeMax) {
            return $data;
        }
        if (!is_null($this->value)) {
            return array_filter($data, function($a) {
                return $a['value'] == $this->value;
            });
        } else {
            return array_filter($data, function($a) {
                return $a['value'] >= $this->rangeMin && (!$this->rangeMax || $a['value'] <= $this->rangeMax);
            });
        }
    }

}