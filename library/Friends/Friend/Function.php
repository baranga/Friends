<?php

class Friends_Friend_Function
    implements Friends_Friend
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = (string) $name;
    }

    public function equal(Friends_Friend $friend)
    {
        if ($friend instanceof Friends_Friend_Function) {
            return $friend->hasName($this->_name);
        }
        return false;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function hasName($name)
    {
        return $this->_name === (string) $name;
    }
}
