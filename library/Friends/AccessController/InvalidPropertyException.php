<?php

class Friends_AccessController_InvalidPropertyException
    extends RuntimeException
{
    public function __construct($property)
    {
        parent::__construct(sprintf(
            'unknown property: "%s"', $property
        ));
    }
}
