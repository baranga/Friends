<?php

interface Friends_Relation
{
    public function getFriends();
    public function isFriend(Friends_Friend $caller);
}
