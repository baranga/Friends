<?php

class Friends_Relation_DispatcherTest
    extends PHPUnit_Framework_TestCase
{
    private $_dispatcher;
    private $_callee;

    public function setUp()
    {
        $this->_dispatcher = new Friends_Dispatcher(
            'Friends_DispatcherTest_Callee', true
        );
        $this->_callee = new Friends_DispatcherTest_Callee($this->_dispatcher);
    }

    /**
     * @covers Friends_Dispatcher::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructorTriggersExceptionOnInvalidClass()
    {
        new Friends_Dispatcher('NonExistingClass');
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException InvalidArgumentException
     */
    public function testDispatchChecksCallTargetIsOfRightType()
    {
        $object = new ArrayObject();
        $dispatcher = new Friends_Dispatcher('Friends_DispatcherTest_Callee');

        $dispatcher->dispatchCall($object, 'count', array());
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testDispatchChecksThatMethodExists()
    {
        $object = new stdClass;
        $dispatcher = new Friends_Dispatcher('stdClass');

        $dispatcher->dispatchCall($object, 'method', array());
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodCallsProtectedCalleeMethod()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);

        $caller->triggerProtectedCall();
        $numOfCalls = $this->_callee->getNumOfProtectedCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodCallsPrivateCalleeMethodIfAllowed()
    {
        $dispatcher = new Friends_Dispatcher(
            'Friends_DispatcherTest_Callee', false
        );
        $callee = new Friends_DispatcherTest_Callee($dispatcher);
        $caller = new Friends_DispatcherTest_MethodFriendCaller($callee);

        $caller->triggerPrivateCall();
        $numOfCalls = $callee->getNumOfPrivateCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerClassCallsProtectedCalleeMethod()
    {
        $caller = new Friends_DispatcherTest_ClassFriendCaller($this->_callee);

        $caller->triggerProtectedCall();
        $numOfCalls = $this->_callee->getNumOfProtectedCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerClassCallsPrivateCalleeMethodIfAllowed()
    {
        $dispatcher = new Friends_Dispatcher(
            'Friends_DispatcherTest_Callee', false
        );
        $callee = new Friends_DispatcherTest_Callee($dispatcher);
        $caller = new Friends_DispatcherTest_ClassFriendCaller($callee);

        $caller->triggerPrivateCall();
        $numOfCalls = $callee->getNumOfPrivateCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testCallToPrivateFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);

        $caller->triggerProtectedCall();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testCallToProtectedFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);

        $caller->triggerPrivateCall();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testCallToPrivateTriggersExceptionIfNotAllowed()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);

        $caller->triggerPrivateCall();
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFrindshipInheritsOnClassBase()
    {
        $dispatcher = new Friends_Dispatcher('Friends_DispatcherTest_ExtendedCallee');
        $callee = new Friends_DispatcherTest_ExtendedCallee($dispatcher);
        $caller = new Friends_DispatcherTest_ClassFriendCaller($callee);

        $caller->triggerProtectedCall();
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFrindshipInheritsOnMethodBase()
    {
        $dispatcher = new Friends_Dispatcher('Friends_DispatcherTest_ExtendedCallee');
        $callee = new Friends_DispatcherTest_ExtendedCallee($dispatcher);
        $caller = new Friends_DispatcherTest_MethodFriendCaller($callee);

        $caller->triggerProtectedCall();
    }
}
