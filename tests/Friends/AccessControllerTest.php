<?php

class Friends_AccessControllerTest
    extends PHPUnit_Framework_TestCase
{
    private $_controller;
    private $_callee;

    public function setUp()
    {
        $this->_controller = $this->_buildController(true);
        $this->_callee = new Friends_AccessControllerTest_Callee();
    }

    private function _buildController($privateLocked = true)
    {
        return new Friends_AccessController(
            'Friends_DispatcherTest_Callee', $privateLocked
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
            'Friends_DispatcherTest_Callee',
            $class
        );
    }

    public function testHasClass()
    {
        $status = $this->_controller->hasClass('Friends_DispatcherTest_Callee');
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
        $this->markTestIncomplete();
    }

    public function testIsGetAllowedIdentifiesStranger()
    {
        $this->markTestIncomplete();
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
    // assert utility
    // -------------------------------------------------------------------------

}
