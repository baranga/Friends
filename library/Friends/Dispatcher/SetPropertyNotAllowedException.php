<?php

class Friends_Dispatcher_SetPropertyNotAllowedException
    extends Friends_Dispatcher_AbstractNotAllowedException
{
    public function __construct($class, $property, $code)
    {
        $message = sprintf(
            'setting of property "%s::%s" is not allowed',
            $class,
            $property
        );
        $message = $this->_appendReasonIfPossible($message, $code);

        parent::__construct($message, $code);
    }
}
