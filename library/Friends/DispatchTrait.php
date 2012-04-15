<?php

trait Friends_Friendships
{
    private $_relation;

    private function _getRelation()
    {
        if ($this->_relation === null) {
            $this->_relation = new Friends_Relation_Class($this);
        }
        return $this->_relation;
    }

    public function __call($method, $arguments)
    {
        $trace = new Friends_Backtrace();
        // go back __call, orig method, caller
        $caller = $trace->offsetGet(2);
        if (!$this->_getRelation()->isFriend($caller)) {
            throw new RuntimeException(sprintf(
                'calling of "%s::%s" is not allowed',
                get_class($this),
                $method
            ));
        }
        return call_user_func(array($this, $method), $arguments);
    }
}
