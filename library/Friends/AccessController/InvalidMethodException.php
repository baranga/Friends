<?php

class Friends_AccessController_InvalidMethodException
    extends RuntimeException
{
    public function __construct($method)
    {
        parent::__construct(sprintf(
            'unknown method: "%s"', $method
        ));
    }
}
