<?php

class Friends_Relation_DocCommentParserTest
    extends PHPUnit_Framework_TestCase
{
    private $_object;

    public function setUp()
    {
        $this->_object = new Friends_Relation_DocCommentParser();
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testFindsSingleFunctionFriend()
    {
        $comment = <<<COMMENT
/**
 * @friend friendFunction
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertSingleFriendList(
            $return, 'Friends_Friend_Function'
        );

        $friend = $return[0];
        $this->assertEquals(
            'friendFunction',
            $friend->getName(),
            'friend knows right function name'
        );
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testFindsSingleClassFriend()
    {
        $comment = <<<COMMENT
/**
 * @friend FriendClass
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertSingleFriendList(
            $return, 'Friends_Friend_Class'
        );

        $friend = $return[0];
        $this->assertEquals(
            'FriendClass',
            $friend->getClass(),
            'friend knows right class name'
        );
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testFindsSingleMethodFriend()
    {
        $comment = <<<COMMENT
/**
 * @friend Class::friendMethod
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertSingleFriendList(
            $return, 'Friends_Friend_Method'
        );

        $friend = $return[0];
        $this->assertEquals(
            'Class',
            $friend->getClass(),
            'friend knows right class name'
        );
        $this->assertEquals(
            'friendMethod',
            $friend->getMethod(),
            'friend knows right method name'
        );
    }

    private function _assertSingleFriendList($list, $friendClass)
    {
        $this->assertInternalType(
            'array', $list,
            'returns list of friends'
        );
        $this->assertEquals(
            count($list), 1,
            'returns a single friend'
        );
        $this->assertInstanceOf(
            $friendClass, $list[0],
            sprintf('got a %s friend', $friendClass)
        );
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testUnderstandsMultiFriendDeclaration()
    {
        $comment = <<<COMMENT
/**
 * @friends friendFunction FriendClass Class::friendMethod
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertMultiFriendList($return);
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testUnderstandsMultiFriendDeclarationWithComma()
    {
        $comment = <<<COMMENT
/**
 * @friends friendFunction, FriendClass, Class::friendMethod
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertMultiFriendList($return);
    }

    /**
     * @covers Friends_Relation_DocCommentParser::parse
     */
    public function testUnderstandsMultiLineDeclaration()
    {
        $comment = <<<COMMENT
/**
 * @friends
 *  friendFunction
 *  FriendClass
 *  Class::friendMethod
 *
 * Some simple documentation.
 */
COMMENT;

        $return = $this->_object->parse($comment);

        $this->_assertMultiFriendList($return);
    }

    private function _assertMultiFriendList($list)
    {
        $this->assertInternalType(
            'array', $list,
            'returns list of friends'
        );
        $this->assertEquals(
            count($list), 3,
            'returns all 3 friend types'
        );
        $this->assertInstanceOf(
            'Friends_Friend_Function', $list[0],
            'first friend is a function'
        );
        $this->assertInstanceOf(
            'Friends_Friend_Class', $list[1],
            'second friend is a class'
        );
        $this->assertInstanceOf(
            'Friends_Friend_Method', $list[2],
            'third friend is a method'
        );
    }
}
