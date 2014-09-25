<?php

namespace Model\Data\Filter;

class Value extends AbstractFilter
{

    protected $rangeMin;

    protected $rangeMax;

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        parent::setValue($value);
        if (strpos($this->value, ' - ') !== false) {
            $this->value = 0;
            list($this->rangeMin, $this->rangeMax) = explode(' - ', $value);
            $this->rangeMin = (float)$this->rangeMin;
            $this->rangeMax = (float)$this->rangeMax;
            if ($this->rangeMin < 0) {
                $this->rangeMin = 0;
            }
            if ($this->rangeMax < 0 || $this->rangeMax < $this->rangeMin) {
                $this->rangeMax = 0;
            }
        } else {
            $this->rangeMin = $this->rangeMax = 0;
            $this->value = (float)$this->value;
            if ($this->value < 0) {
                $this->value = 0;
            }
        }
        return $this;
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
        if ($this->value > 0) {
            return array_filter($data, function($a) {
                if (!is_array($a) || !array_key_exists('value', $a)) {
                    return false;
                }
                return $a['value'] == $this->value;
            });
        } else {
            return array_filter($data, function($a) {
                if (!is_array($a) || !array_key_exists('value', $a)) {
                    return false;
                }
                return $a['value'] >= $this->rangeMin && (!$this->rangeMax || $a['value'] <= $this->rangeMax);
            });
        }
    }

}