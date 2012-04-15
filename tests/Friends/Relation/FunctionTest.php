<?php

include_once dirname(__FILE__) . '/FunctionTest/test.php';

class Friends_Relation_FunctionTest
    extends PHPUnit_Framework_TestCase
{
    const TEST_FUNCTION = 'Friends_Relation_FunctionTest_test';

    /**
     * @covers Friends_Relation_Function::__construct
     * @covers Friends_Relation_Function::getFunction
     */
    public function testConatinerFunctionality()
    {
        $function = self::TEST_FUNCTION;

        $container = new Friends_Relation_Function($function);
        $containerFunction = $container->getFunction();

        $this->assertEquals(
            $function, $containerFunction,
            'returns class'
        );
    }

    /**
     * @covers Friends_Relation_Function::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionOnInvalidFunction()
    {
        new Friends_Relation_Function(
            'notExistingFunction'
        );
    }

    /**
     * @covers Friends_Relation_Function
     * @covers Friends_Relation_AbstractRelation
     */
    public function testGetFriends()
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers Friends_Relation_Function::isFriend
     */
    public function testIsFriendWithFriends()
    {
        $friends = array(
            new Friends_Friend_Function('test'),
            new Friends_Friend_Class('Test'),
            new Friends_Friend_Method('Test', 'test'),
        );
        $relation = new Friends_Relation_Function(self::TEST_FUNCTION);

        foreach ($friends as $friend) {
            $this->assertTrue(
                $relation->isFriend($friend),
                'relation detects friends'
            );
        }
    }

    /**
     * @covers Friends_Relation_Function::isFriend
     */
    public function testIsFriendWithStrangers()
    {
        $strangers = array(
            new Friends_Friend_Function('stranger'),
            new Friends_Friend_Class('Stranger'),
            new Friends_Friend_Method('Stranger', 'stranger'),
        );
        $relation = new Friends_Relation_Function(self::TEST_FUNCTION);

        foreach ($strangers as $stranger) {
            $this->assertFalse(
                $relation->isFriend($stranger),
                'relation detects stragers'
            );
        }
    }
}
