<?php

namespace MystiqueTest\PHP\Token;

use \Mystique\PHP\Token\Tokenizer;
use \Mystique\Common\Token\TokenStream;
use Mystique\Common\Util\PairMatcher;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Mystique\PHP\Token\PairMatcher
 */
class PairMatcherTest extends PHPUnit_Framework_TestCase {
    function testPairMatcher() {
        $this->assertEquals('}', PairMatcher::skipToParen(new TokenStream(Tokenizer::tokenizePhp('{}')))->value);
    }

    function testPairMatcherNested() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('{{}}'));
        $this->assertEquals('}', PairMatcher::skipToParen($stream)->value);
        $this->assertEquals(3, $stream->key());
    }

    function testPairMatcherNested2() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('{{}}'));
        $stream->next();
        $this->assertEquals('}', PairMatcher::skipToParen($stream)->value);
        $this->assertEquals(2, $stream->key());
    }


    /**
     * @expectedException UnexpectedValueException
     */
    function testNestingErrorThrowsException() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('{{}'));
        PairMatcher::skipToParen($stream);
    }


    /**
     * @expectedException UnexpectedValueException
     */
    function testInvalidPointerThrowsException() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('no paren'));
        PairMatcher::skipToParen($stream);
    }
}