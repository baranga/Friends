<?php

abstract class Friends_DispatcherTest_AbstractCaller
{
    protected $_callee;

    public function __construct(
        Friends_DispatcherTest_Callee $callee
    )
    {
        $this->_callee = $callee;
    }
}