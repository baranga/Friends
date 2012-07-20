<?php

abstract class Friends_DispatchingTraitTest_AbstractCaller
{
    protected $_callee;

    public function __construct(
        Friends_DispatchingTraitTest_Callee $callee
    )
    {
        $this->_callee = $callee;
    }
}
