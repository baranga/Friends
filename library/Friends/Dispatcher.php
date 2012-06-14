<?php

class Friends_Dispatcher
{
    private $_accessController;

    public function __construct(
        Friends_AccessControllerInterface $accessController
    )
    {
        // @codeCoverageIgnoreStart
        if (!method_exists('ReflectionProperty', 'setAccessible')) {
            throw Friends_Dispatcher_MissingLanguageFeatureException
                ::missingSetMethodAccessible();
        }
        if (!method_exists('ReflectionMethod', 'setAccessible')) {
            throw Friends_Dispatcher_MissingLanguageFeatureException
                ::missingSetMethodAccessible();
        }
        // @codeCoverageIgnoreEnd

        $this->_accessController = $accessController;
    }

    public function dispatchGet($object, $property)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);

        // check getter
        $getter = $this->_getCaller(2);
        $this->_accessController->assertGetIsAllowed($property, $getter);

        $propertyReflector = new ReflectionProperty($object, $property);
        $propertyReflector->setAccessible(true);
        return $propertyReflector->getValue($object);
    }

    public function dispatchSet($object, $property, $value)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);

        // check setter
        $setter = $this->_getCaller(2);
        $this->_accessController->assertSetIsAllowed($property, $setter);

        $propertyReflector = new ReflectionProperty($object, $property);
        $propertyReflector->setAccessible(true);
        $propertyReflector->setValue($object, $value);
    }

    public function dispatchCall($object, $method, array $arguments)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);

        // check caller
        $caller = $this->_getCaller(3);
        $this->_accessController->assertCallIsAllowed($method, $caller);

        $methodReflector = new ReflectionMethod($object, $method);
        $methodReflector->setAccessible(true);
        return $methodReflector->invokeArgs($object, $arguments);
    }

    private function _assertObjectIsOfMyClass($object)
    {
        $class = $this->_accessController->getClass();
        if (!is_object($object) ||
            !$object instanceof $class
        ) {
            throw new Friends_Dispatcher_InvalidObjectException(
                $object, $class
            );
        }
    }

    /** @brief caller of dispatch*
     *  @param $level
     *  @return Friends_Friend
     */
    private function _getCaller($level)
    {
        $trace = new Friends_Backtrace();
        return $trace->offsetGet($level + 1);
    }
}
