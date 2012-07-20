<?php

/**
 * @friend Friends_DispatchingTraitTest_ClassFriendCaller
 */
class Friends_DispatchingTraitTest_Callee
{
    use Friends_DispatchingTrait;

    protected $_numOfPublicCalls    = 0;
    protected $_numOfProtectedCalls = 0;
    protected $_numOfPrivateCalls   = 0;

    public function receivePublicCall()
    {
        $this->_numOfPublicCalls += 1;
    }

    /**
     * @friend Friends_DispatchingTraitTest_MethodFriendCaller::triggerProtectedCall
     */
    protected function _receiveProtectedCall()
    {
        $this->_numOfProtectedCalls += 1;
    }

    /**
     * @friend Friends_DispatchingTraitTest_MethodFriendCaller::triggerPrivateCall
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
