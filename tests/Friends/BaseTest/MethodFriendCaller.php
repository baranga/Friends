<?php

class Friends_BaseTest_MethodFriendCaller
    extends Friends_BaseTest_AbstractCaller
{
    public function triggerPublicCall()
    {
        $this->_callee->receivePublicCall();
    }

    public function triggerProtectedCall()
    {
        $this->_callee->_receiveProtectedCall();
    }

    public function triggerPrivateCall()
    {
        $this->_callee->_receivePrivateCall();
    }
}
