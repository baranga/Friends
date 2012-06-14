<?php

class Friends_DispatcherTest_AccessController
    implements Friends_AccessControllerInterface
{
    private $_class;
    private $_allowed = false;

    public function __construct($class, $allowed)
    {
        $this->setClass($class);
        $this->setAllowed($allowed);
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function setClass($class)
    {
        $this->_class = (string) $class;
    }

    public function setAllowed($allowed)
    {
        $this->_allowed = (bool) $allowed;
    }

    public function isGetAllowed($property, Friends_Friend $getter)
    {
        return $this->_allowed;
    }

    public function assertGetIsAllowed($property, Friends_Friend $getter)
    {
        $this->_assertAllowed();
    }

    public function isSetAllowed($property, Friends_Friend $setter)
    {
        return $this->_allowed;
    }

    public function assertSetIsAllowed($property, Friends_Friend $getter)
    {
        $this->_assertAllowed();
    }

    public function isCallAllowed($method, Friends_Friend $caller)
    {
        return $this->_allowed;
    }

    public function assertCallIsAllowed($property, Friends_Friend $getter)
    {
        $this->_assertAllowed();
    }

    private function _assertAllowed()
    {
        if (!$this->_allowed) {
            throw new RuntimeException(
                'assertIsAllowedException',
                123
            );
        }
    }
}