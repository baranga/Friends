<?php

class Friends_Friend_MethodTest
    extends Friends_Friend_TestAbstract
{
    public function testConatinerFunctionality()
    {
        $class = 'Test';
        $method = 'test';

        $container = new Friends_Friend_Method($class, $method);
        $containerClass = $container->getClass();
        $containerMethod = $container->getMethod();

        $this->assertEquals(
            $class, $containerClass,
            'returns class'
        );
        $this->assertEquals(
            $method, $containerMethod,
            'returns method'
        );
    }

    public function testEquality()
    {
        $a = new Friends_Friend_Method('Test', 'test');
        $b = new Friends_Friend_Method('Test', 'test');

        $this->_assertBidirectionalEquality($a, $b);
    }

    public function testUnequalityOnDifferentClasses()
    {
        $a = new Friends_Friend_Method('A', 'test');
        $b = new Friends_Friend_Method('B', 'test');

        $this->_assertBidirectionalUnequality($a, $b);
    }

    public function testUnequalityOnDifferentMethods()
    {
        $a = new Friends_Friend_Method('Test', 'a');
        $b = new Friends_Friend_Method('Test', 'b');

        $this->_assertBidirectionalUnequality($a, $b);
    }
}
