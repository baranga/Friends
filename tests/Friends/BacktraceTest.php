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
        $this->markTestIncomplete();
    }

    public function testOffsetSetIsNotAllowed()
    {
        $this->markTestIncomplete();
    }

    public function testOffsetUnsetIsNotAllowed()
    {
        $this->markTestIncomplete();
    }

    public function testOffsetExists()
    {
        $this->markTestIncomplete();
    }

    public function testOffestGet()
    {
        $this->markTestIncomplete();
    }
}
