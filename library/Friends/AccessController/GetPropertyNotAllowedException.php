<?php

class Friends_AccessController_GetPropertyNotAllowedException
    extends Friends_AccessController_AbstractNotAllowedException
{
    public function __construct($class, $property)
    {
        parent::__construct(sprintf(
            'getting of property "%s::%s" is not allowed',
            $class,
            $property
        ));
    }
}
