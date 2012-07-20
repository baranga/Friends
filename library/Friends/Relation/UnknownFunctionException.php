<?php

class Friends_Relation_UnknownFunctionException
    extends RuntimeException
    implements Friends_Relation_ExceptionInterface
{
    public function __construct($function)
    {
        parent::__construct(sprintf(
            'unknown function: "%s"', $function
        ));
    }
}
