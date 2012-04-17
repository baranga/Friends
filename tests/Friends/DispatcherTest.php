<?php

class Friends_DispatcherTest
    extends PHPUnit_Framework_TestCase
{
    private $_dispatcher;
    private $_callee;

    const PROPERTYVALUE_PUBLIC    = 'public property test value';
    const PROPERTYVALUE_PROTECTED = 'protected property test value';
    const PROPERTYVALUE_PRIVATE   = 'private property test value';

    public function setUp()
    {
        $this->_dispatcher = $this->_buildDispatcher(true);
        $this->_callee = $this->_buildCallee($this->_dispatcher);
    }

    private function _buildDispatcher($privateLocked = true)
    {
        return new Friends_Dispatcher(
            'Friends_DispatcherTest_Callee', $privateLocked
        );
    }

    private function _buildCallee(Friends_Dispatcher $dispatcher)
    {
        return new Friends_DispatcherTest_Callee(
            $dispatcher,
            self::PROPERTYVALUE_PUBLIC,
            self::PROPERTYVALUE_PROTECTED,
            self::PROPERTYVALUE_PRIVATE
        );
    }

    /**
     * @covers Friends_Dispatcher::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructorTriggersExceptionOnInvalidClass()
    {
        new Friends_Dispatcher('NonExistingClass');
    }

    // -------------------------------------------------------------------------
    // dispatchGet
    // -------------------------------------------------------------------------

    /**
     * @covers Friends_Dispatcher
     * @expectedException InvalidArgumentException
     */
    public function testDispatchGetChecksTargetIsOfRightType()
    {
        $object = new ArrayObject();
        $dispatcher = new Friends_Dispatcher('Friends_DispatcherTest_Callee');

        $dispatcher->dispatchGet($object, 'property');
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testDispatchGetChecksThatPropertyExists()
    {
        $object = new stdClass;
        $dispatcher = new Friends_Dispatcher('stdClass');

        $dispatcher->dispatchGet($object, 'property');
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodGetProtectedCalleeProperty()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);
        $value = $caller->getProtectedProperty();

        $this->assertEquals(
            self::PROPERTYVALUE_PROTECTED,
            $value
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodGetPrivateCalleeProperty()
    {
        $dispatcher = $this->_buildDispatcher(false);
        $callee = $this->_buildCallee($dispatcher);
        $caller = new Friends_DispatcherTest_MethodFriendCaller($callee);

        $value = $caller->getPrivateProperty();

        $this->assertEquals(
            self::PROPERTYVALUE_PRIVATE, $value
        );
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testGetOfPrivatePropertyTriggersExceptionIfNotAllowed()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);
        $caller->getPrivateProperty();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testGetOfPrivatePropertyFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);
        $caller->getPrivateProperty();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testGetOfProtectedPropertyFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);
        $caller->getProtectedProperty();
    }

    // -------------------------------------------------------------------------
    // dispatchSet
    // -------------------------------------------------------------------------

    /**
     * @covers Friends_Dispatcher
     * @expectedException InvalidArgumentException
     */
    public function testDispatchSetChecksTargetIsOfRightType()
    {
        $object = new ArrayObject();
        $dispatcher = new Friends_Dispatcher('Friends_DispatcherTest_Callee');

        $dispatcher->dispatchSet($object, 'property', 'value');
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testDispatchSetChecksThatPropertyExists()
    {
        $object = new stdClass;
        $dispatcher = new Friends_Dispatcher('stdClass');

        $dispatcher->dispatchSet($object, 'property', 'value');
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodSetProtectedCalleeProperty()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);

        $caller->setProtectedProperty(__METHOD__);
        $settedValue = $this->_callee->getProtectedProperty();

        $this->assertEquals(__METHOD__, $settedValue);
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testFriendCallerMethodSetPrivateCalleeProperty()
    {
        $dispatcher = $this->_buildDispatcher(false);
        $callee = $this->_buildCallee($dispatcher);
        $caller = new Friends_DispatcherTest_MethodFriendCaller($callee);

        $caller->setPrivateProperty(__METHOD__);
        $settedValue = $callee->getPrivateProperty();

        $this->assertEquals(__METHOD__, $settedValue);
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testSetOfPrivatePropertyTriggersExceptionIfNotAllowed()
    {
        $caller = new Friends_DispatcherTest_MethodFriendCaller($this->_callee);

        $caller->setPrivateProperty(__METHOD__);
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testSetOfPrivatePropertyFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);

        $caller->setProtectedProperty(__METHOD__);
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     */
    public function testSetOfProtectedPropertyFromStrangerTriggersException()
    {
        $caller = new Friends_DispatcherTest_StrangerCaller($this->_callee);

        $caller->setPrivateProperty(__METHOD__);
    }

    // -------------------------------------------------------------------------
    // dispatchCall
    // -------------------------------------------------------------------------

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
        $dispatcher = $this->_buildDispatcher(false);
        $callee = $this->_buildCallee($dispatcher);
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
        $dispatcher = $this->_buildDispatcher(false);
        $callee = $this->_buildCallee($dispatcher);
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
