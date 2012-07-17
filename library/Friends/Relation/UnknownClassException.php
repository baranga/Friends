<?php

class Friends_Relation_UnknownClassException
    extends RuntimeException
{
    public function __construct($class)
    {
        parent::__construct(sprintf(
            'unknown class: "%s"', $class
        ));
    }
}
