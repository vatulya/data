<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class UnitHelper extends \Codeception\Module
{

    /**
     * @param string $exception
     * @param callable $function
     * @return bool
     */
    public function seeExceptionThrown($exception, $function)
    {
        try {
            $function();
        } catch (\Exception $e) {
            if (get_class($e) == $exception) {
                return true;
            }
        }
        return false;
    }

    public function getProtectedProperty($object, $propertyName)
    {
        $class = new \ReflectionObject($object);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    public function callProtectedMethod($object, $methodName, $params)
    {
        $class = new \ReflectionObject($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $params);
    }

}