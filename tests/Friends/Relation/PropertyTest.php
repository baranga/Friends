<?php

class Friends_Relation_PropertyTest
    extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS = 'Friends_Relation_PropertyTest_Test';
    const TEST_PROPERTY = '_test';

    private $_object;

    public function setUp()
    {
        $this->_object = new Friends_Relation_Property(
            self::TEST_CLASS, self::TEST_PROPERTY
        );
    }

    /**
     * @covers Friends_Relation_Property::__construct
     * @covers Friends_Relation_Property::getClass
     * @covers Friends_Relation_Property::getProperty
     */
    public function testConatinerFunctionality()
    {
        $containerClass = $this->_object->getClass();
        $containerProperty = $this->_object->getProperty();

        $this->assertEquals(
            self::TEST_CLASS, $containerClass,
            'returns class'
        );
        $this->assertEquals(
            self::TEST_PROPERTY, $containerProperty,
            'returns property'
        );
    }

    /**
     * @covers Friends_Relation_Property::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionOnInvalidClass()
    {
        new Friends_Relation_Property(
            'NotExistingClass', '_test'
        );
    }

    /**
     * @covers Friends_Relation_Property::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionOnInvalidProperty()
    {
        new Friends_Relation_Property(
            'stdClass', 'notExistingProperty'
        );
    }

    /**
     * @covers Friends_Relation_Property
     * @covers Friends_Relation_AbstractRelation
     */
    public function testGetFriends()
    {
        $expectedFriends = $this->_getFriends();
        $friends = $this->_object->getFriends();
        $this->assertEquals(
            $expectedFriends,
            $friends
        );
    }

    /**
     * @covers Friends_Relation_Property::isFriend
     */
    public function testIsFriendWithFriends()
    {
        $friends = $this->_getFriends();
        foreach ($friends as $friend) {
            $this->assertTrue(
                $this->_object->isFriend($friend),
                'relation detects friends'
            );
        }
    }

    private function _getFriends()
    {
        return array(
            new Friends_Friend_Function('test'),
            new Friends_Friend_Class('Test'),
            new Friends_Friend_Method('Test', 'test')
        );
    }

    /**
     * @covers Friends_Relation_Property::isFriend
     */
    public function testIsFriendWithStrangers()
    {
        $functionFriend = $this->_object->isFriend(
            new Friends_Friend_Function('strager')
        );
        $classFriend = $this->_object->isFriend(
            new Friends_Friend_Class('Stranger')
        );
        $methodFriend = $this->_object->isFriend(
            new Friends_Friend_Method('Stranger', 'strager')
        );

        $this->assertFalse(
            $functionFriend,
            'relation has not stranger as function friend'
        );
        $this->assertFalse(
            $classFriend,
            'relation has not stranger as class friend'
        );
        $this->assertFalse(
            $methodFriend,
            'relation has not stranger as method friend'
        );
    }
}
