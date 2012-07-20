<?php

class Friends_Relation_UnknownClassException
    extends RuntimeException
    implements Friends_Relation_ExceptionInterface
{
    public function __construct($class)
    {
        parent::__construct(sprintf(
            'unknown class: "%s"', $class
        ));
    }
}
