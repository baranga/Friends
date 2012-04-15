<?php

class Friends_DispatcherTest_ExtendedCallee
    extends Friends_DispatcherTest_Callee
{
    public function receivePublicCall()
    {
        return parent::receivePublicCall();
    }

    protected function _receiveProtectedCall()
    {
        return parent::_receiveProtectedCall();
    }

    private function _receivePrivateCall()
    {
        $this->_numOfPrivateCalls += 1;
    }
}
