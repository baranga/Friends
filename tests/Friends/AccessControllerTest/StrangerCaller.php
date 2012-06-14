<?php

class Friends_AccessControllerTest_StrangerCaller
    extends Friends_AccessControllerTest_AbstractCaller
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

    public function getPublicProperty()
    {
        return $this->_callee->publicProperty;
    }

    public function setPublicProperty($value)
    {
        $this->_callee->publicProperty = $value;
    }

    public function getProtectedProperty()
    {
        return $this->_callee->_protectedProperty;
    }

    public function setProtectedProperty($value)
    {
        $this->_callee->_protectedProperty = $value;
    }

    public function getPrivateProperty()
    {
        return $this->_callee->_privateProperty;
    }

    public function setPrivateProperty($value)
    {
        $this->_callee->_privateProperty = $value;
    }
}
