<?php

class Friends_BacktraceTest_Base
{
    public function getBacktrace()
    {
        return new Friends_Backtrace();
    }

    static public function getBacktraceStatic()
    {
        return new Friends_Backtrace();
    }
}
