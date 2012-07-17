<?php

class Friends_Relation_UnknownMethodException
    extends RuntimeException
{
    public function __construct($class, $method)
    {
        parent::__construct(sprintf(
            'unknown method: "%s::%s"', $class, $method
        ));
    }
}
