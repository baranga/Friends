<?php

/**
 * @friend Friends_AccessControllerTest_ClassFriendCaller
 */
class Friends_AccessControllerTest_Callee
{
    public $publicProperty;

    /**
     * @friend Friends_AccessControllerTest_MethodFriendCaller::getProtectedProperty
     * @friend Friends_AccessControllerTest_MethodFriendCaller::setProtectedProperty
     */
    protected $_protectedProperty;

    /**
     * @friend Friends_AccessControllerTest_MethodFriendCaller::getPrivateProperty
     * @friend Friends_AccessControllerTest_MethodFriendCaller::setPrivateProperty
     */
    private $_privateProperty;

    public function publicMethod() {}

    /**
     * @friend Friends_AccessControllerTest_MethodFriendCaller::triggerProtectedCall
     */
    protected function _protectedMethod() {}

    /**
     * @friend Friends_AccessControllerTest_MethodFriendCaller::triggerPrivateCall
     */
    private function _privateMethod() {}
}
