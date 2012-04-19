<?php

class Friends_Dispatcher_CallMethodNotAllowedException
    extends Friends_Dispatcher_AbstractNotAllowedException
{
    public function __construct($class, $method, $code)
    {
        $message = sprintf(
            'calling of method "%s::%s" is not allowed',
            $class,
            $method
        );
        $message = $this->_appendReasonIfPossible($message, $code);

        parent::__construct($message, $code);
    }
}
