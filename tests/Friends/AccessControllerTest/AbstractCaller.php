<?php

abstract class Friends_AccessControllerTest_AbstractCaller
{
    protected $_callee;

    public function __construct(
        Friends_AccessControllerTest_Callee $callee
    )
    {
        $this->_callee = $callee;
    }
}
