<?php

class Friends_Friend_Method
    extends Friends_Friend_Class
{
    private $_method;

    public function __construct($class, $method)
    {
        parent::__construct($class);
        $this->_method = (string) $method;
    }

    public function equal(Friends_FriendInterface $friend)
    {
        if ($friend instanceof Friends_Friend_Method) {
            return
                parent::equal($friend) &&
                $friend->hasMethod($this->_method)
            ;
        }
        return false;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function hasMethod($method)
    {
        return $this->_method === (string) $method;
    }
}
