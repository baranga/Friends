<?php

class Friends_Friend_ClassTest
    extends Friends_Friend_TestAbstract
{
    public function testConatinerFunctionality()
    {
        $class = 'Test';

        $container = new Friends_Friend_Class($class);
        $containerClass = $container->getClass();

        $this->assertEquals(
            $class, $containerClass,
            'returns class'
        );
    }

    public function testEqualityOnClass()
    {
        $a = new Friends_Friend_Class('Test');
        $b = new Friends_Friend_Class('Test');

        $this->_assertBidirectionalEquality($a, $b);
    }

    public function testUnidirectionalEqualityForClassToMethod()
    {
        $a = new Friends_Friend_Class('Test');
        $b = new Friends_Friend_Method('Test', 'test');

        $this->_assertUnidirectionalEquality($a, $b);
    }

    public function testUnequalityOnClass()
    {
        $a = new Friends_Friend_Class('A');
        $b = new Friends_Friend_Class('B');

        $this->_assertBidirectionalUnequality($a, $b);
    }

    public function testUnequalityOnMethod()
    {
        $a = new Friends_Friend_Class('A');
        $b = new Friends_Friend_Method('B', 'b');

        $this->_assertBidirectionalUnequality($a, $b);
    }

    public function testUnequalityOnFunction()
    {
        $a = new Friends_Friend_Class('A');
        $b = new Friends_Friend_Function('A');

        $this->_assertBidirectionalUnequality($a, $b);
    }
}
