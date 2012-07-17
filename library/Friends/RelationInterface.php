<?php

interface Friends_RelationInterface
{
    public function getFriends();
    public function isFriend(Friends_FriendInterface $caller);
}
