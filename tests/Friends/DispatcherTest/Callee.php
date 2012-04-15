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

    public function __construct(
        Friends_Dispatcher $dispatcher
    )
    {
        $this->_dispatcher = $dispatcher;
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
}
