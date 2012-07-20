<?php

class Friends_DispatchingTraitTest
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $this->markTestSkipped('PHP version < 5.4.0');
            return;
        }
    }

    public function testDispatch()
    {
        $callee = new Friends_DispatchingTraitTest_Callee();
        $classCaller = new Friends_DispatchingTraitTest_ClassFriendCaller($callee);
        $methodCaller = new Friends_DispatchingTraitTest_MethodFriendCaller($callee);

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
