<?php

class Friends_BaseTest
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (version_compare(PHP_VERSION, '5.3.2', '<')) {
            $this->markTestSkipped('PHP version < 5.3.2');
            return;
        }
    }

    public function testDispatch()
    {
        $callee = new Friends_BaseTest_Callee();
        $classCaller = new Friends_BaseTest_ClassFriendCaller($callee);
        $methodCaller = new Friends_BaseTest_MethodFriendCaller($callee);

        $classCaller->triggerPublicCall();
        $methodCaller->triggerPublicCall();
        $numOfPublicCalls = $callee->getNumOfPublicCalls();

        $classCaller->triggerProtectedCall();
        $methodCaller->triggerProtectedCall();
        $numOfProtectedCalls = $callee->getNumOfProtectedCalls();

        $this->assertEquals(2, $numOfPublicCalls);
        $this->assertEquals(2, $numOfProtectedCalls);
    }
}
