<?php

abstract class Friends_BaseTest_AbstractCaller
{
    protected $_callee;

    public function __construct(
        Friends_BaseTest_Callee $callee
    )
    {
        $this->_callee = $callee;
    }
}
