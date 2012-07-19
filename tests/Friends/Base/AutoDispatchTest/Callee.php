<?php

/**
 * @friend Friends_Base_AutoDispatchTest_ClassFriendCaller
 */
class Friends_Base_AutoDispatchTest_Callee
    extends Friends_Base_AutoDispatch
{
    protected $_numOfPublicCalls    = 0;
    protected $_numOfProtectedCalls = 0;
    protected $_numOfPrivateCalls   = 0;

    public function receivePublicCall()
    {
        $this->_numOfPublicCalls += 1;
    }

    /**
     * @friend Friends_Base_AutoDispatchTest_MethodFriendCaller::triggerProtectedCall
     */
    protected function _receiveProtectedCall()
    {
        $this->_numOfProtectedCalls += 1;
    }

    /**
     * @friend Friends_Base_AutoDispatchTest_MethodFriendCaller::triggerPrivateCall
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
