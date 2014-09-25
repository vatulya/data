<?php

namespace Controller;

abstract class AbstractController
{

    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'index';

    const SEND_HTML = 'html';
    const SEND_JSON = 'json';

    /**
     * @var array
     */
    protected $view = [];

    /**
     * @var bool
     */
    protected $needRender = true;

    /**
     * @return null
     */
    abstract public function indexAction();

    /**
     * @param string $action
     * @param string $controller
     */
    static public function load($controller, $action)
    {
        if (empty($controller)) {
            $controller = self::DEFAULT_CONTROLLER;
        }
        if (empty($action)) {
            $action = self::DEFAULT_ACTION;
        }
        $class = '\Controller\\' . ucfirst(strtolower($controller));
        $method = ucfirst(strtolower($action)) . 'Action';
        if (!class_exists($class) || !is_callable([$class, $method], true)) {
            die('Can\'t load "' . $class . '::' . $method . '"');
        }
        try {
            /** @var AbstractController $object */
            $object = new $class();
            $object->$method();
            if ($object->isNeedRender()) {
                $object->render($controller, $action);
            }
        } catch (\Exception $e) {
            die('Exception: "' . $e->getMessage() . '" (' . $e->getFile() . ':' . $e->getLine() . ')');
        }
    }

    /**
     * @return $this
     */
    protected function noRender()
    {
        $this->needRender = false;
        return $this;
    }

    /**
     * @return $this
     */
    protected function needRender()
    {
        $this->needRender = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNeedRender()
    {
        return (bool)$this->needRender;
    }

    /**
     * @param string $controller
     * @param string $action
     */
    public function render($controller, $action)
    {
        $file = sprintf('%s/%s.html', strtolower($controller), strtolower($action));
        $content = self::getTwig()->render($file, $this->view);
        self::send($content);
    }

    /**
     * @return \Twig_Environment
     */
    static protected function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem(APPLICATION_PATH . '/templates');
        return new \Twig_Environment($loader);
    }

    /**
     * @param mixed $data
     * @param string $format
     */
    static protected function send($data, $format = self::SEND_HTML)
    {
        switch ($format) {
            case self::SEND_JSON:
                $data = json_encode($data);
                break;

            case self::SEND_HTML:
            default:
                // nothing. default action.
                break;
        }
        echo (string)$data;
    }

}