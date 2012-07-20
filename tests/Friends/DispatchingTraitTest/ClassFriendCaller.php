<?php

class Friends_DispatchingTraitTest_ClassFriendCaller
    extends Friends_DispatchingTraitTest_AbstractCaller
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
