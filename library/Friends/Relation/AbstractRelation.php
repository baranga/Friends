<?php

abstract class Friends_Relation_AbstractRelation
    implements Friends_Relation
{
    private $_friends = array();

    protected function __construct(array $friends)
    {
        foreach ($friends as $friend) {
            if (!$friend instanceof Friends_Friend) {
                throw new InvalidArgumentException('invalid friend');
            }
        }
        $this->_friends = $friends;
    }

    public function getFriends()
    {
        return $this->_friends;
    }

    public function isFriend(Friends_Friend $other)
    {
        foreach ($this->_friends as $friend) {
            if ($friend->equal($other)) {
                return true;
            }
        }
        return false;
    }
}
