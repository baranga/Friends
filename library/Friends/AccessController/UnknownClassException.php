<?php

class Friends_AccessController_UnknownClassException
    extends InvalidArgumentException
    implements Friends_AccessController_ExceptionInterface
{
    public function __construct($class)
    {
        parent::__construct(sprintf(
            'unknown class: "%s"', $class
        ));
    }
}
