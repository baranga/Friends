<?php

require_once dirname(__FILE__) . '/BacktraceTest/function.php';

class Friends_BacktraceTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Friends_Backtrace
     */
    public function testTraceOfFunction()
    {
        $trace = Friends_BacktraceTest_function();

        $this->assertInstanceOf(
            'Friends_Backtrace', $trace
        );

        $function = $trace->offsetGet(0);
        $this->assertInstanceOf(
            'Friends_Friend_Function', $function
        );

        $functionName = $function->getName();
        $this->assertEquals(
            'Friends_BacktraceTest_function', $functionName
        );
    }

    public function testTraceOfBaseMethod()
    {
        $this->_testTraceOfMethod(
            'Friends_BacktraceTest_Base', 'getBacktrace'
        );
    }

    public function testTraceOfExtendedMethod()
    {
        $this->_testTraceOfMethod(
            'Friends_BacktraceTest_Extended', 'getBacktrace'
        );
    }

    public function testTraceOfBaseStaticMethod()
    {
        $trace = Friends_BacktraceTest_Base::getBacktraceStatic();
        $this->_assertTrace(
            'Friends_BacktraceTest_Base', 'getBacktraceStatic', $trace
        );
    }

    public function testTraceOfExtendedStaticMethod()
    {
        $trace = Friends_BacktraceTest_Extended::getBacktraceStatic();
        $this->_assertTrace(
            'Friends_BacktraceTest_Base', 'getBacktraceStatic', $trace
        );
    }

    private function _testTraceOfMethod($class, $method)
    {
        $object = new $class();
        $trace = $object->$method();
        $this->_assertTrace($class, $method, $trace);
    }

    private function _assertTrace($class, $method, $trace)
    {
        $this->assertInstanceOf(
            'Friends_Backtrace', $trace
        );

        $traceEntry = $trace->offsetGet(0);
        $this->assertInstanceOf(
            'Friends_Friend_Method', $traceEntry
        );

        $traceEntryClass = $traceEntry->getClass();
        $traceEntryMethod = $traceEntry->getMethod();
        $this->assertEquals(
            $class, $traceEntryClass
        );
        $this->assertEquals(
            $method, $traceEntryMethod
        );
    }

    public function testToArray()
    {
        $trace = new Friends_Backtrace();
        $array = $trace->toArray();

        $this->assertInternalType('array', $array);
        $this->assertGreaterThan(1, count($array));
    }

    /**
     * @expectedException Friends_Backtrace_ReadonlyException
     */
    public function testOffsetSetIsNotAllowed()
    {
        $trace = new Friends_Backtrace();
        $trace->offsetSet(0, 'test');
    }

    /**
     * @expectedException Friends_Backtrace_ReadonlyException
     */
    public function testOffsetUnsetIsNotAllowed()
    {
        $trace = new Friends_Backtrace();
        $trace->offsetUnset(0);
    }

    public function testOffsetExistsWithValidOffset()
    {
        $trace = new Friends_Backtrace();
        $validOffset = $trace->offsetExists(0);
        $this->assertTrue($validOffset);
    }

    public function testOffsetExistsWithInvalidOffset()
    {
        $trace = new Friends_Backtrace();
        $invalidOffset = $trace->offsetExists('test');
        $this->assertFalse($invalidOffset);
    }

    public function testOffestGetWithValidOffset()
    {
        $trace = new Friends_Backtrace();
        $return = $trace->offsetGet(0);

        $this->assertInstanceOf(
            'Friends_Friend_Method',
            $return
        );
        $this->assertEquals(
            __CLASS__,
            $return->getClass()
        );
        $this->assertEquals(
            __FUNCTION__,
            $return->getMethod()
        );
    }

    public function testOffestGetWithInvalidOffset()
    {
        $trace = new Friends_Backtrace();
        $return = $trace->offsetGet('test');
        $this->assertNull($return);
    }
}
