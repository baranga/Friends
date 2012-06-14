<?php

class Friends_AccessController_CallMethodNotAllowedException
    extends Friends_AccessController_AbstractNotAllowedException
{
    public function __construct($class, $method)
    {
        parent::__construct(sprintf(
            'calling of method "%s::%s" is not allowed',
            $class,
            $method
        ));
    }
}
