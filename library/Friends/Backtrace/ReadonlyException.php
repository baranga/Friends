<?php

class Friends_Backtrace_ReadonlyException
    extends LogicException
    implements Friends_Backtrace_ExceptionInterface
{
    public function __construct()
    {
        parent::__construct('trace is readonly');
    }
}
