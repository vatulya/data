<?php

class Config
{

    /**
     * @var static
     */
    static protected $instance;

    /**
     * @var array
     */
    protected $config;

    static public function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @param array $config
     * @return $this
     * @throws Exception
     */
    public function load(array $config)
    {
        if (is_array($this->config)) {
            throw new \Exception('You can\'t rewrite config');
        }
        $this->config = $config;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    static public function get($key)
    {
        return getArrayValue(static::getInstance()->config, $key);
    }

}