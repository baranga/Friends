<?php

class Friends_Dispatcher
{
    private $_class;
    private $_lockPrivate = true;

    private $_classRelation = null;
    private $_propertyRelations = array();
    private $_methodRelations = array();

    public function __construct($class, $lockPrivate = true)
    {
        // @codeCoverageIgnoreStart
        if (!method_exists('ReflectionMethod', 'setAccessible')) {
            throw new RuntimeException('ReflectionMethod::setAccessible not found');
        }
        // @codeCoverageIgnoreEnd

        $class = (string) $class;
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf(
                'valid class name required, got: "%s"', $class
            ));
        }

        $this->_class       = $class;
        $this->_lockPrivate = (bool) $lockPrivate;
    }

    public function dispatchGet($object, $property)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);
        $objectReflector = new ReflectionObject($object);

        // check property
        $property = (string) $property;
        $this->_assertObjectHasProperty($objectReflector, $property);
        $propertyReflector = $objectReflector->getProperty($property);

        // check for private
        if ($this->_lockPrivate && $propertyReflector->isPrivate()) {
            throw new RuntimeException(sprintf(
                'getting of "%s::%s" is not allowed (private)',
                $this->_class,
                $property
            ));
        }

        // check for friendship
        // go back: dispatch*, __* magic method, calling method
        $caller = $this->_getCaller(2);
        if (!$this->_isPropertyFriend($property, $caller)) {
            throw new RuntimeException(sprintf(
                'getting of "%s::%s" is not allowed',
                $this->_class,
                $property
            ));
        }

        $propertyReflector->setAccessible(true);
        return $propertyReflector->getValue($object);
    }

    public function dispatchSet($object, $property, $value)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);
        $objectReflector = new ReflectionObject($object);

        // check property
        $property = (string) $property;
        $this->_assertObjectHasProperty($objectReflector, $property);
        $propertyReflector = $objectReflector->getProperty($property);

        // check for private
        if ($this->_lockPrivate && $propertyReflector->isPrivate()) {
            throw new RuntimeException(sprintf(
                'setting of "%s::%s" is not allowed (private)',
                $this->_class,
                $property
            ));
        }

        // check for friendship
        // go back: dispatch*, __* magic method, calling method
        $caller = $this->_getCaller(2);
        if (!$this->_isPropertyFriend($property, $caller)) {
            throw new RuntimeException(sprintf(
                'setting of "%s::%s" is not allowed',
                $this->_class,
                $property
            ));
        }

        $propertyReflector->setAccessible(true);
        $propertyReflector->setValue($object, $value);
    }

    public function dispatchCall($object, $method, array $arguments)
    {
        // check object
        $this->_assertObjectIsOfMyClass($object);
        $objectReflector = new ReflectionObject($object);

        // check method
        $method = (string) $method;
        $this->_assertObjectHasMethod($objectReflector, $method);
        $methodReflector = $objectReflector->getMethod($method);

        // check for private
        if ($this->_lockPrivate && $methodReflector->isPrivate()) {
            throw new RuntimeException(sprintf(
                'calling of "%s::%s" is not allowed (private)',
                $this->_class,
                $method
            ));
        }

        // check for friendship
        // go back: dispatch*, __* magic method, called method, calling method
        $caller = $this->_getCaller(3);
        if (!$this->_isMethodFriend($method, $caller)) {
            throw new RuntimeException(sprintf(
                'calling of "%s::%s" is not allowed',
                $this->_class,
                $method
            ));
        }

        $methodReflector->setAccessible(true);
        return $methodReflector->invokeArgs($object, $arguments);
    }

    private function _assertObjectIsOfMyClass($object)
    {
        if (!is_object($object) ||
            !$object instanceof $this->_class
        ) {
            throw new InvalidArgumentException(
                'invalid object provided'
            );
        }
    }

    private function _assertObjectHasProperty(
        ReflectionObject $objectReflector, $property
    )
    {
        if (!$objectReflector->hasProperty($property)) {
            throw new RuntimeException(sprintf('unknown property: "%s"', $property));
        }
    }

    private function _assertObjectHasMethod(
        ReflectionObject $objectReflector, $method
    )
    {
        if (!$objectReflector->hasMethod($method)) {
            throw new RuntimeException(sprintf('unknown method: "%s"', $method));
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

    /** @brief class relationship
     *  @return Friends_Relation_Class
     */
    private function _getClassRelation()
    {
        if ($this->_classRelation === null) {
            $this->_classRelation = new Friends_Relation_Class($this->_class);
        }
        return $this->_classRelation;
    }

    /** @brief property relationship
     *  @param string $property property name
     *  @return Friends_Relation_Property
     */
    private function _getPropertyRelation($property)
    {
        if (!isset($this->_propertyRelations[$property])) {
            $this->_propertyRelations[$property] = new Friends_Relation_Property(
                $this->_class, $property
            );
        }
        return $this->_propertyRelations[$property];
    }

    /** @brief method relationship
     *  @param string $method method name
     *  @return Friends_Relation_Method
     */
    private function _getMethodRelation($method)
    {
        if (!isset($this->_methodRelations[$method])) {
            $this->_methodRelations[$method] = new Friends_Relation_Method(
                $this->_class, $method
            );
        }
        return $this->_methodRelations[$method];
    }

    /** @brief check if caller is a friend of property
     *  @param string $property
     *  @param Friends_Friend $caller
     *  @return boolean
     */
    private function _isPropertyFriend($property, Friends_Friend $caller)
    {
        return
            $this->_getClassRelation()->isFriend($caller) ||
            $this->_getPropertyRelation($property)->isFriend($caller);
    }

    /** @brief check if caller is a friend of method
     *  @param string $method
     *  @param Friends_Friend $caller
     *  @return boolean
     */
    private function _isMethodFriend($method, Friends_Friend $caller)
    {
        return
            $this->_getClassRelation()->isFriend($caller) ||
            $this->_getMethodRelation($method)->isFriend($caller);
    }

}
