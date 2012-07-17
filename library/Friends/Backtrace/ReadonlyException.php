<?php

class Friends_Backtrace_ReadonlyException
    extends LogicException
{
    public function __construct()
    {
        parent::__construct('trace is readonly');
    }
}
