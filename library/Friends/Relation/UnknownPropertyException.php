<?php

class Friends_Relation_UnknownPropertyException
    extends RuntimeException
{
    public function __construct($class, $property)
    {
        parent::__construct(sprintf(
            'unknown property: "%s::%s"', $class, $property
        ));
    }
}
