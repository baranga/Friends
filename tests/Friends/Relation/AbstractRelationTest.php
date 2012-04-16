<?php

class Friends_Relation_AbstractRelationTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideInvalidFriends
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionOnInvalidFriends($invalidFriends)
    {
        new Friends_Relation_AbstractRelationTest_Stub($invalidFriends);
    }

    public function provideInvalidFriends()
    {
        return array(
            array(array(1)),
            array(array('Test')),
        );
    }

    public function testConatinerFunctionality()
    {
        $expectedFriends = array(
            new Friends_Friend_Class('Test'),
            new Friends_Friend_Method('Test', 'test'),
            new Friends_Friend_Function('test'),
        );

        $relation = new Friends_Relation_AbstractRelationTest_Stub($expectedFriends);
        $friends = $relation->getFriends();

        $this->assertEquals(
            $expectedFriends,
            $friends
        );
    }
}
