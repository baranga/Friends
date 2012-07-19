<?php

abstract class Friends_Base_AutoDispatchTest_AbstractCaller
{
    protected $_callee;

    public function __construct(
        Friends_Base_AutoDispatchTest_Callee $callee
    )
    {
        $this->_callee = $callee;
    }
}
