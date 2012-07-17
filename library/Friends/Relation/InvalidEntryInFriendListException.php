<?php

class Friends_Relation_InvalidEntryInFriendListException
    extends RuntimeException
{
    public function __construct($key, $friend)
    {
        parent::__construct(sprintf(
            'friend list has invalid entry under key: "%s"',
            $key
        ));
    }
}
