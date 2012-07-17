<?php

abstract class Friends_Relation_AbstractRelation
    implements Friends_RelationInterface
{
    private $_friends = array();

    protected function __construct(array $friends)
    {
        foreach ($friends as $friend) {
            if (!$friend instanceof Friends_FriendInterface) {
                throw new InvalidArgumentException('invalid friend');
            }
        }
        $this->_friends = $friends;
    }

    public function getFriends()
    {
        return $this->_friends;
    }

    public function isFriend(Friends_FriendInterface $other)
    {
        foreach ($this->_friends as $friend) {
            if ($friend->equal($other)) {
                return true;
            }
        }
        return false;
    }
}
