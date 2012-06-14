<?php

class Friends_AccessController_UnknownClassException
    extends InvalidArgumentException
{
    public function __construct($class)
    {
        parent::__construct(sprintf(
            'unknown class: "%s"', $class
        ));
    }
}
