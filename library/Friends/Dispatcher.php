<?php

class Friends_Dispatcher
{
    private $_class;
    private $_lockPrivate = true;

    private $_classRelation = null;
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

    public function dispatchCall($object, $method, array $arguments)
    {
        // check object
        if (!is_object($object) ||
            !$object instanceof $this->_class
        ) {
            throw new InvalidArgumentException(
                'invalid object provided'
            );
        }
        $objectReflector = new ReflectionObject($object);

        // check method
        $method = (string) $method;
        if (!$objectReflector->hasMethod($method)) {
            throw new RuntimeException(sprintf('unknown method: "%s"', $method));
        }
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
        $caller = $this->_getCaller();
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

    /** @brief caller of dispatch*
     *  @return Friends_Friend
     */
    private function _getCaller()
    {
        $trace = new Friends_Backtrace();
        // go back: _getCaller, dispatch*, __* magic method, calling method
        return $trace->offsetGet(4);
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
