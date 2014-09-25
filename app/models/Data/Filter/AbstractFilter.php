<?php

namespace Model\Data\Filter;

abstract class AbstractFilter
{

    protected $value;

    /**
     * @param array $data
     * @return array
     */
    abstract public function filter(array $data);

    /**
     * @param string $filter
     * @param mixed $value
     * @return AbstractFilter
     * @throws \Exception
     */
    static public function factory($filter, $value = null)
    {
        $class = 'Model\Data\Filter\\' . ucfirst(strtolower($filter));
        if (!class_exists($class)) {
            throw new \Exception('Can\'t load data filter class "' . $class . '"');
        }
        return new $class($value);
    }

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $value = is_scalar($value) ? (string)$value : '';
        $this->value = $value;
        return $this;
    }

}