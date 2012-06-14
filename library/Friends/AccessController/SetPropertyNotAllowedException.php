<?php

class Friends_AccessController_SetPropertyNotAllowedException
    extends Friends_AccessController_AbstractNotAllowedException
{
    public function __construct($class, $property)
    {
        parent::__construct(sprintf(
            'setting of property "%s::%s" is not allowed',
            $class,
            $property
        ));
    }
}
