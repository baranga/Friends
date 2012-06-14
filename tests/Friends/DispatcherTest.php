<?php

class Friends_DispatcherTest
    extends PHPUnit_Framework_TestCase
{
    const PROPERTYVALUE_PUBLIC    = 'public property test value';
    const PROPERTYVALUE_PROTECTED = 'protected property test value';
    const PROPERTYVALUE_PRIVATE   = 'private property test value';

    private $_accessController;
    private $_dispatcher;
    private $_callee;
    private $_caller;

    public function setUp()
    {
        if (version_compare(PHP_VERSION, '5.3.2', '<')) {
            $this->markTestSkipped('PHP version < 5.3.2');
            return;
        }
        $this->_accessController = $this->_buildAccessController(
            'Friends_DispatcherTest_Callee'
        );
        $this->_dispatcher = $this->_buildDispatcher($this->_accessController);
        $this->_callee = $this->_buildCallee($this->_dispatcher);
        $this->_caller = $this->_buildCaller($this->_callee);
    }

    private function _buildAccessController($class)
    {
        $controller = new Friends_DispatcherTest_AccessController(
            $class, false
        );
        return $controller;
    }

    private function _buildDispatcher($accessController)
    {
        return new Friends_Dispatcher(
            $accessController
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

    private function _buildCaller(Friends_DispatcherTest_Callee $callee)
    {
        return new Friends_DispatcherTest_Caller($callee);
    }

    // -------------------------------------------------------------------------
    // dispatchGet
    // -------------------------------------------------------------------------

    /**
     * @covers Friends_Dispatcher
     * @expectedException Friends_Dispatcher_InvalidObjectException
     */
    public function testDispatchGetChecksTargetIsOfRightType()
    {
        $object = new ArrayObject();

        $this->_dispatcher->dispatchGet($object, 'property');
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testGetProtectedProperty()
    {
        $this->_accessController->setAllowed(true);

        $value = $this->_caller->getProtectedProperty();

        $this->assertEquals(
            self::PROPERTYVALUE_PROTECTED,
            $value
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testGetPrivateProperty()
    {
        $this->_accessController->setAllowed(true);

        $value = $this->_caller->getPrivateProperty();

        $this->assertEquals(
            self::PROPERTYVALUE_PRIVATE, $value
        );
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testGetOfProtectedPropertyTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);
        $this->_caller->getProtectedProperty();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testGetOfPrivatePropertyTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);
        $this->_caller->getPrivateProperty();
    }

    // -------------------------------------------------------------------------
    // dispatchSet
    // -------------------------------------------------------------------------

    /**
     * @covers Friends_Dispatcher
     * @expectedException Friends_Dispatcher_InvalidObjectException
     */
    public function testDispatchSetChecksTargetIsOfRightType()
    {
        $object = new ArrayObject();

        $this->_dispatcher->dispatchSet($object, 'property', 'value');
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testSetProtectedProperty()
    {
        $this->_accessController->setAllowed(true);

        $this->_caller->setProtectedProperty(__METHOD__);
        $settedValue = $this->_callee->getProtectedProperty();

        $this->assertEquals(__METHOD__, $settedValue);
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testSetPrivateProperty()
    {
        $this->_accessController->setAllowed(true);

        $this->_caller->setPrivateProperty(__METHOD__);
        $settedValue = $this->_callee->getPrivateProperty();

        $this->assertEquals(__METHOD__, $settedValue);
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testSetOfProtectedPropertyTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);

        $this->_caller->setProtectedProperty(__METHOD__);
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testSetOfPrivatePropertyTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);

        $this->_caller->setPrivateProperty(__METHOD__);
    }

    // -------------------------------------------------------------------------
    // dispatchCall
    // -------------------------------------------------------------------------

    /**
     * @covers Friends_Dispatcher
     * @expectedException Friends_Dispatcher_InvalidObjectException
     */
    public function testDispatchChecksCallTargetIsOfRightType()
    {
        $object = new ArrayObject();

        $this->_dispatcher->dispatchCall($object, 'count', array());
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testDispatchChecksThatMethodExists()
    {
        $object = new stdClass;
        $this->_accessController->setClass('stdClass');

        $this->_dispatcher->dispatchCall($object, 'method', array());
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testCallProtectedMethod()
    {
        $this->_accessController->setAllowed(true);

        $this->_caller->triggerProtectedCall();
        $numOfCalls = $this->_callee->getNumOfProtectedCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     */
    public function testCallPrivateMethod()
    {
        $this->_accessController->setAllowed(true);

        $this->_caller->triggerPrivateCall();
        $numOfCalls = $this->_callee->getNumOfPrivateCalls();

        $this->assertEquals(
            1, $numOfCalls,
            'callee received 1 call'
        );
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testCallToProtectedTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);

        $this->_caller->triggerProtectedCall();
    }

    /**
     * @covers Friends_Dispatcher
     * @expectedException RuntimeException
     * @expectedExceptionCode 123
     */
    public function testCallToPrivateTriggersExceptionIfNotAllowed()
    {
        $this->_accessController->setAllowed(false);

        $this->_caller->triggerPrivateCall();
    }
}
