<?php

/**
 * @friend Friends_DispatcherTest_ClassFriendCaller
 */
class Friends_DispatcherTest_Callee
{
    protected $_numOfPublicCalls    = 0;
    protected $_numOfProtectedCalls = 0;
    protected $_numOfPrivateCalls   = 0;
    protected $_dispatcher;

    public $publicProperty;

    /**
     * @friend Friends_DispatcherTest_MethodFriendCaller::getProtectedProperty
     * @friend Friends_DispatcherTest_MethodFriendCaller::setProtectedProperty
     */
    protected $_protectedProperty;

    /**
     * @friend Friends_DispatcherTest_MethodFriendCaller::getPrivateProperty
     * @friend Friends_DispatcherTest_MethodFriendCaller::setPrivateProperty
     */
    private $_privateProperty;

    public function __construct(
        Friends_Dispatcher $dispatcher,
        $publicProperty = null,
        $protectedProperty = null,
        $privateProperty = null
    )
    {
        $this->_dispatcher = $dispatcher;

        $this->publicProperty = $publicProperty;
        $this->_protectedProperty = $protectedProperty;
        $this->_privateProperty = $privateProperty;
    }

    public function __get($property)
    {
        return $this->_dispatcher->dispatchGet($this, $property);
    }

    public function __set($property, $value)
    {
        return $this->_dispatcher->dispatchSet($this, $property, $value);
    }

    public function __call($method, $arguments)
    {
        return $this->_dispatcher->dispatchCall($this, $method, $arguments);
    }

    public function receivePublicCall()
    {
        $this->_numOfPublicCalls += 1;
    }

    /**
     * @friend Friends_DispatcherTest_MethodFriendCaller::triggerProtectedCall
     */
    protected function _receiveProtectedCall()
    {
        $this->_numOfProtectedCalls += 1;
    }

    /**
     * @friend Friends_DispatcherTest_MethodFriendCaller::triggerPrivateCall
     */
    private function _receivePrivateCall()
    {
        $this->_numOfPrivateCalls += 1;
    }

    public function getNumOfPublicCalls()
    {
        return $this->_numOfPublicCalls;
    }

    public function getNumOfProtectedCalls()
    {
        return $this->_numOfProtectedCalls;
    }

    public function getNumOfPrivateCalls()
    {
        return $this->_numOfPrivateCalls;
    }

    public function getPublicProperty()
    {
        return $this->publicProperty;
    }

    public function getProtectedProperty()
    {
        return $this->_protectedProperty;
    }

    public function getPrivateProperty()
    {
        return $this->_privateProperty;
    }
}
