<?php

class Friends_Base_SelfDispatch
{
    public function __get($property)
    {
        $trace = new Friends_Backtrace();
        $getter = $trace[1];
        $this->_getAccessController()->assertGetIsAllowed($getter);
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $trace = new Friends_Backtrace();
        $setter = $trace[1];
        $this->_getAccessController()->assertSetIsAllowed($setter);
        $this->$property = $value;
    }

    public function __call($method, $arguments)
    {
        $trace = new Friends_Backtrace();
        $caller = $trace[2];
        $this->_getAccessController()->assertCallIsAllowed($method, $caller);
        return call_user_func_array(
            array($this, $method),
            $arguments
        );
    }

    /** access controller
     * @return Friends_AccessController
     */
    protected function _getAccessController()
    {
        return new Friends_AccessController($this);
    }
}