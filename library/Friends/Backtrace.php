<?php

class Friends_Backtrace
    implements ArrayAccess
{
    private $_trace;

    public function __construct()
    {
        $trace = debug_backtrace();

        // first entry represents this method so remove
        array_shift($trace);

        $this->_trace = $trace;
    }

    private function _convertTrace(array $trace)
    {
        $converted = array();
        foreach ($trace as $traceEntry) {
            $converted[] = $this->_convertTraceEntry($traceEntry);
        }
        return $converted;
    }

    private function _convertTraceEntry(array $traceEntry)
    {
        //var_dump($traceEntry);
        if (isset($traceEntry['object'])) {
            return new Friends_Friend_Method(
                get_class($traceEntry['object']), $traceEntry['function']
            );
        } elseif (isset($traceEntry['class'])) {
            return new Friends_Friend_Method(
                $traceEntry['class'], $traceEntry['function']
            );
        } else {
            return new Friends_Friend_Function(
                $traceEntry['function']
            );
        }
    }

    public function toArray()
    {
        return $this->_convertTrace($this->_trace);
    }

    public function offsetSet($offset, $value)
    {
        throw new Friends_Backtrace_ReadonlyException();
    }

    public function offsetExists($offset)
    {
        return isset($this->_trace[$offset]);
    }

    public function offsetUnset($offset)
    {
        throw new Friends_Backtrace_ReadonlyException();
    }

    public function offsetGet($offset)
    {
        if (isset($this->_trace[$offset])) {
            return $this->_convertTraceEntry($this->_trace[$offset]);
        } else {
            return null;
        }
    }
}
