<?php

class Friends_Relation_ClassTest
    extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS = 'Friends_Relation_ClassTest_Test';

    /**
     * @covers Friends_Relation_Class::__construct
     * @covers Friends_Relation_Class::getClass
     */
    public function testConatinerFunctionality()
    {
        $class = self::TEST_CLASS;

        $container = new Friends_Relation_Class($class);
        $containerClass = $container->getClass();

        $this->assertEquals(
            $class, $containerClass,
            'returns class'
        );
    }

    /**
     * @covers Friends_Relation_Class::__construct
     * @covers Friends_Relation_Class::getClass
     */
    public function testConstructHandlesObject()
    {
        $class = self::TEST_CLASS;
        $object = new $class();
        $relation = new Friends_Relation_Class($object);
        $relationClass = $relation->getClass();

        $this->assertEquals(
            $class, $relationClass,
            'returns class'
        );
    }

    /**
     * @covers Friends_Relation_Class::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionOnInvalidClass()
    {
        new Friends_Relation_Class(
            'NotExistingClass'
        );
    }

    /**
     * @covers Friends_Relation_Class
     * @covers Friends_Relation_AbstractRelation
     */
    public function testGetFriends()
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers Friends_Relation_Class::isFriend
     */
    public function testIsFriendWithFriends()
    {
        $friends = array(
            new Friends_Friend_Function('test'),
            new Friends_Friend_Class('Test'),
            new Friends_Friend_Method('Test', 'test'),
        );
        $relation = new Friends_Relation_Class(self::TEST_CLASS);

        foreach ($friends as $friend) {
            $this->assertTrue(
                $relation->isFriend($friend),
                'relation detects friends'
            );
        }
    }

    /**
     * @covers Friends_Relation_Class::isFriend
     */
    public function testIsFriendWithStrangers()
    {
        $strangers = array(
            new Friends_Friend_Function('stranger'),
            new Friends_Friend_Class('Stranger'),
            new Friends_Friend_Method('Stranger', 'stranger'),
        );
        $relation = new Friends_Relation_Class(self::TEST_CLASS);

        foreach ($strangers as $stranger) {
            $this->assertFalse(
                $relation->isFriend($stranger),
                'relation detects stragers'
            );
        }
    }
}
