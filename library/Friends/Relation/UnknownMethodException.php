<?php

class Friends_Relation_UnknownMethodException
    extends RuntimeException
    implements Friends_Relation_ExceptionInterface
{
    public function __construct($class, $method)
    {
        parent::__construct(sprintf(
            'unknown method: "%s::%s"', $class, $method
        ));
    }
}
