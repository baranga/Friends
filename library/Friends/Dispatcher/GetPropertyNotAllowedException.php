<?php

class Friends_Dispatcher_GetPropertyNotAllowedException
    extends Friends_Dispatcher_AbstractNotAllowedException
{
    public function __construct($class, $property, $code)
    {
        $message = sprintf(
            'getting of property "%s::%s" is not allowed',
            $class,
            $property
        );
        $message = $this->_appendReasonIfPossible($message, $code);

        parent::__construct($message, $code);
    }
}
