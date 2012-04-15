<?php

class Friends_Friend_FunctionTest
    extends Friends_Friend_TestAbstract
{
    public function testConatinerFunctionality()
    {
        $function = 'test';

        $container = new Friends_Friend_Function($function);
        $containerFunction = $container->getName();

        $this->assertEquals(
            $function, $containerFunction,
            'returns class'
        );
    }

    public function testEquality()
    {
        $a = new Friends_Friend_Function('Test');
        $b = new Friends_Friend_Function('Test');

        $this->_assertBidirectionalEquality($a, $b);
    }

    public function testUnequality()
    {
        $a = new Friends_Friend_Function('A');
        $b = new Friends_Friend_Function('B');

        $this->_assertBidirectionalUnequality($a, $b);
    }
}
