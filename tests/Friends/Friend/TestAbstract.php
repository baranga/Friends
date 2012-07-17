<?php

abstract class Friends_Friend_TestAbstract
    extends PHPUnit_Framework_TestCase
{
    protected function _assertUnidirectionalEquality(
        Friends_FriendInterface $a, Friends_FriendInterface $b
    )
    {
        $this->assertTrue(
            $a->equal($b),
            'a is equal b'
        );
    }

    protected function _assertBidirectionalEquality(
        Friends_FriendInterface $a, Friends_FriendInterface $b
    )
    {
        $this->assertTrue(
            $a->equal($b),
            'a is equal b'
        );
        $this->assertTrue(
            $b->equal($a),
            'b is equal a'
        );
    }

    protected function _assertUnidirectionalUnequality(
        Friends_FriendInterface $a, Friends_FriendInterface $b
    )
    {
        $this->assertFalse(
            $a->equal($b),
            'a is unequal b'
        );
    }

    protected function _assertBidirectionalUnequality(
        Friends_FriendInterface $a, Friends_FriendInterface $b
    )
    {
        $this->assertFalse(
            $a->equal($b),
            'a is unequal b'
        );
        $this->assertFalse(
            $b->equal($a),
            'b is unequal a'
        );
    }
}
