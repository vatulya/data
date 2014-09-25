<?php

namespace Model\Data\Source;

abstract class AbstractSource
{

    protected $config;

    /**
     * @param string $source
     * @return AbstractSource
     * @throws \Exception
     */
    static public function factory($source)
    {
        $class = 'Model\Data\Source\\' . ucfirst(strtolower($source));
        if (!class_exists($class)) {
            throw new \Exception('Can\'t load source adapter class "' . $class . '"');
        }
        $config = getArrayValue(getArrayValue(\Config::get('data'), 'sources', []), strtolower($source), []);
        return new $class($config);
    }

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    abstract public function getData();

}