<?php

class Friends_Relation_UnknownFunctionException
    extends RuntimeException
{
    public function __construct($function)
    {
        parent::__construct(sprintf(
            'unknown function: "%s"', $function
        ));
    }
}
