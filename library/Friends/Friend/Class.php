<?php

class Friends_Friend_Class
    implements Friends_Friend
{
    private $_class;

    public function __construct($class)
    {
        $this->_class = (string) $class;
    }

    public function equal(Friends_Friend $friend)
    {
        if ($friend instanceof Friends_Friend_Class) {
            return $friend->hasClass($this->_class);
        }
        return false;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function hasClass($class)
    {
        return $this->_class === (string) $class;
    }
}
