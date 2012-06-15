<?php

class Friends_AccessControllerTest
    extends PHPUnit_Framework_TestCase
{
    const CLASS_CALLEE = 'Friends_AccessControllerTest_Callee';

    /**
     * @var Friends_AccessController
     */
    private $_controller;

    /**
     * @var Friends_AccessControllerTest_Callee
     */
    private $_callee;

    public function setUp()
    {
        $this->_controller = $this->_buildController(true);
        $this->_callee = new Friends_AccessControllerTest_Callee();
    }

    private function _buildController($privateLocked = true)
    {
        return new Friends_AccessController(
            self::CLASS_CALLEE, $privateLocked
        );
    }

    /**
     * @covers Friends_Dispatcher::__construct
     * @expectedException Friends_AccessController_UnknownClassException
     */
    public function testConstructorTriggersExceptionOnInvalidClass()
    {
        new Friends_AccessController('NonExistingClass');
    }

    public function testGetClass()
    {
        $class = $this->_controller->getClass();
        $this->assertEquals(
            self::CLASS_CALLEE,
            $class
        );
    }

    public function testHasClass()
    {
        $status = $this->_controller->hasClass(self::CLASS_CALLEE);
        $this->assertTrue($status);
    }

    // -------------------------------------------------------------------------
    // get access
    // -------------------------------------------------------------------------

    public function testIsGetAllowedChecksPropertyExists()
    {
        $this->markTestIncomplete();
    }

    public function testIsGetAllowedIdentifiesFriend()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_MethodFriendCaller',
            'getProtectedProperty'
        );

        $allowed = $this->_controller->isGetAllowed($property, $getter);

        $this->assertTrue($allowed);
    }

    public function testIsGetAllowedIdentifiesStranger()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_StrangerFriendCaller',
            'getProtectedProperty'
        );

        $allowed = $this->_controller->isGetAllowed($property, $getter);

        $this->assertFalse($allowed);
    }

    public function testIsGetAllowedDoesntAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    public function testIsGetAllowedDoesAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    // -------------------------------------------------------------------------
    // set access
    // -------------------------------------------------------------------------

    public function testIsSetAllowedChecksPropertyExists()
    {
        $this->markTestIncomplete();
    }

    public function testIsSetAllowedIdentifiesFriend()
    {
        $this->markTestIncomplete();
    }

    public function testIsSetAllowedIdentifiesStranger()
    {
        $this->markTestIncomplete();
    }

    public function testIsSetAllowedDoesntAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    public function testIsSetAllowedDoesAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    // -------------------------------------------------------------------------
    // call access
    // -------------------------------------------------------------------------

    public function testIsCallAllowedChecksMetohdExists()
    {
        $this->markTestIncomplete();
    }

    public function testIsCallAllowedChecksPropertyExists()
    {
        $this->markTestIncomplete();
    }

    public function testIsCallAllowedIdentifiesFriend()
    {
        $this->markTestIncomplete();
    }

    public function testIsCallAllowedIdentifiesStranger()
    {
        $this->markTestIncomplete();
    }

    public function testIsCallAllowedDoesntAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    public function testIsCallAllowedDoesAllowPrivateIfConfigured()
    {
        $this->markTestIncomplete();
    }

    // -------------------------------------------------------------------------
    // assert utilities
    // -------------------------------------------------------------------------

    public function testAssertGetIsAllowedPassesOnFriend()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_MethodFriendCaller',
            'getProtectedProperty'
        );
        $this->_controller->assertGetIsAllowed($property, $getter);
    }

    /**
     * @expectedException Friends_AccessController_GetPropertyNotAllowedException
     */
    public function testAssertGetIsAllowedThrowsOnStranger()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_StrangerCaller',
            'getProtectedProperty'
        );
        $this->_controller->assertGetIsAllowed($property, $getter);
    }

    public function testAssertSetIsAllowedPassesOnFriend()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_MethodFriendCaller',
            'setProtectedProperty'
        );
        $this->_controller->assertSetIsAllowed($property, $getter);
    }

    /**
     * @expectedException Friends_AccessController_SetPropertyNotAllowedException
     */
    public function testAssertSetIsAllowedThrowsOnStranger()
    {
        $property = '_protectedProperty';
        $getter = new Friends_Friend_Method(
            'Friends_AccessControllerTest_StrangerCaller',
            'setProtectedProperty'
        );
        $this->_controller->assertSetIsAllowed($property, $getter);
    }

    public function testAssertCallIsAllowedPassesOnFriend()
    {
        $method = '_protectedMethod';
        $caller = new Friends_Friend_Method(
            'Friends_AccessControllerTest_MethodFriendCaller',
            'callProtectedMethod'
        );
        $this->_controller->assertSetIsAllowed($method, $caller);
    }

    /**
     * @expectedException Friends_AccessController_CallMethodNotAllowedException
     */
    public function testAssertCallIsAllowedThrowsOnStranger()
    {
        $method = '_protectedMethod';
        $caller = new Friends_Friend_Method(
            'Friends_AccessControllerTest_StrangerCaller',
            'callProtectedMethod'
        );
        $this->_controller->assertSetIsAllowed($method, $caller);
    }
}
