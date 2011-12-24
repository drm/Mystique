<?php

namespace MystiqueTest\PHP\Token;

use PHPUnit_Framework_TestCase;
use \Mystique\PHP\Token\Token;


/**
 * @covers \Mystique\PHP\Token\Token
 */
class TokenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider tokens
     */
    function testConstruction($type, $value, $token) {
        $token = new Token($token);
        $this->assertEquals($type, $token->type);
        $this->assertEquals($value, $token->value);
    }


    function testStringCast() {
        foreach($this->tokens() as $tok) {
            $token = new Token($tok[2]);
            $this->assertEquals($tok[1], (string)$token);
        }
    }


    function testMatch() {
        $token = new Token(array(T_WHITESPACE, ' '));
        $this->assertTrue($token->match(T_WHITESPACE));
        $this->assertFalse($token->match(T_WHITESPACE, "\n"));
        $this->assertTrue($token->match(clone $token));
        $this->assertTrue($token->match(array(T_WHITESPACE, T_OPEN_TAG)));
        $this->assertTrue($token->match(array(T_OPEN_TAG, T_WHITESPACE)));
    }


    function tokens() {
        $ret = array();
        $ret[]=array(T_WHITESPACE, ' ', array(T_WHITESPACE, ' '));
        $ret[]=array('{', '{', '{');
        return $ret;
    }
}