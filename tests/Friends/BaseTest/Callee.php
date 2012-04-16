<?php

/**
 * @friend Friends_BaseTest_ClassFriendCaller
 */
class Friends_BaseTest_Callee
    extends Friends_Base
{
    protected $_numOfPublicCalls    = 0;
    protected $_numOfProtectedCalls = 0;
    protected $_numOfPrivateCalls   = 0;

    public function receivePublicCall()
    {
        $this->_numOfPublicCalls += 1;
    }

    /**
     * @friend Friends_BaseTest_MethodFriendCaller::triggerProtectedCall
     */
    protected function _receiveProtectedCall()
    {
        $this->_numOfProtectedCalls += 1;
    }

    /**
     * @friend Friends_BaseTest_MethodFriendCaller::triggerPrivateCall
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
