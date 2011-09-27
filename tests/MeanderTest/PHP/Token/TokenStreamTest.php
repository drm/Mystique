<?php

namespace MeanderTest\PHP\Token;
use PHPUnit_Framework_TestCase;

use \Meander\PHP\Token\Token;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Tokenizer;


/**
 * @covers \Meander\PHP\Token\TokenStream
 */
class StreamTest extends PHPUnit_Framework_TestCase {
    function testToString() {
        $this->assertEquals(
            '<?php function foo() {}',
            (string)new TokenStream(token_get_all('<?php function foo() {}'))
        );
    }


    function testIteration() {
        $this->assertEquals(
            array(
                new Token(array(T_OPEN_TAG, '<?php ')),
                new Token(array(T_FUNCTION, 'function')),
                new Token(array(T_WHITESPACE, ' ')),
                new Token(array(T_STRING, 'foo')),
                new Token('('),
                new Token(')'),
                new Token(array(T_WHITESPACE, ' ')),
                new Token('{'),
                new Token('}')
            ),
            iterator_to_array($stream = new TokenStream(token_get_all('<?php function foo() {}'), array()))
        );
        return $stream;
    }

    /**
     * @depends testIteration
     */
    function testReiteration($stream) {
        $this->assertEquals(
            array(
                new Token(array(T_OPEN_TAG, '<?php ')),
                new Token(array(T_FUNCTION, 'function')),
                new Token(array(T_WHITESPACE, ' ')),
                new Token(array(T_STRING, 'foo')),
                new Token('('),
                new Token(')'),
                new Token(array(T_WHITESPACE, ' ')),
                new Token('{'),
                new Token('}')
            ),
            iterator_to_array($stream)
        );
    }


    function testInsertionAfter() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function foo() {}'), array());

        foreach($stream as $i => $token) {
            if($token->value == '(') {
                $stream->insert(new Token(array(T_VARIABLE, '$param1')));
            }
        }

        $this->assertEquals('function foo($param1) {}', (string)$stream);
    }


    function testInsertionBefore() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function foo() {}'));

        foreach ($stream as $i => $token) {
            if ($token->value == ')') {
                $stream->insert(new Token(array(T_VARIABLE, '$param1')), true);
            }
        }

        $this->assertEquals('function foo($param1) {}', (string)$stream);
    }

    function testInjectionBefore() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function foo() {}'));

        foreach($stream as $i => $token) {
            if($token->value == ')') {
                $stream->inject(new TokenStream(Tokenizer::tokenizePhp('$param1 = null'), array()), true);
            }
        }

        $this->assertEquals('function foo($param1 = null) {}', (string)$stream);
    }


    function testInjectionAfter() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function foo() {}'));

        foreach ($stream as $i => $token) {
            if ($token->value == '(') {
                $stream->inject(new TokenStream(Tokenizer::tokenizePhp('$param1 = null'), array()));
            }
        }

        $this->assertEquals('function foo($param1 = null) {}', (string)$stream);
    }


    function testRemove() {
        $stream = new TokenStream(Tokenizer::tokenizePhp(' ( $a && ! $b ) '));

        for($i = 0; $i < count($stream);) {
            if ($stream->tokenAt($i)->type == T_WHITESPACE) {
                $stream->remove($i);
            } else {
                $i ++;
            }
        }
        $this->assertEquals('($a&&!$b)', (string)$stream);
    }

    /**
     * @expectedException OutOfBoundsException
     */
    function testForwardThrowsExceptionIfBeyondEOF() {
        $stream = new TokenStream();
        $stream->forward();
    }


    /**
     * @expectedException OutOfBoundsException
     */
    function testBackThrowsExceptionIfBefore0() {
        $stream = new TokenStream();
        $stream->back();
    }


    function testPeek() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function a'), array());
        $stream->next();
        $this->assertEquals(' ', $stream->current()->value);
        $this->assertEquals('a', $stream->peek()->value);
        $this->assertEquals('function', $stream->peekBack()->value);
    }


    function testForward() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function a'), array());
        $stream->next();
        $stream2 = new TokenStream(Tokenizer::tokenizePhp('function a'), array());
        $stream2->forward(1);

        $this->assertEquals($stream->current(), $stream2->current());
    }

    
    function testBack() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('function a'), array());
        $stream2 = new TokenStream(Tokenizer::tokenizePhp('function a'), array());
        $stream2->next();
        $stream2->back();

        $this->assertEquals($stream->current(), $stream2->current());
    }

    /**
     * @expectedException OutOfBoundsException
     */
    function testPeekThrowsExceptionIfBeyondEOF() {
        $stream = new TokenStream();
        $stream->peek();
    }


    /**
     * @expectedException OutOfBoundsException
     */
    function testPeekBackThrowsExceptionIfBeyondEOF() {
        $stream = new TokenStream();
        $stream->peekBack();
    }


    function testIgnoreIteration() {
        $stream = new TokenStream(Tokenizer::tokenizePhp(' class a extends b '));
        $stream->ignore(T_WHITESPACE);

        $this->assertEquals(
            array('class', 'a', 'extends', 'b'),
            array_values(
                array_map(
                    function($t) {
                        return $t->value;
                    },
                    iterator_to_array($stream)
                )
            )
        );
    }

    function testIgnoredPeek() {
        $stream = new TokenStream(Tokenizer::tokenizePhp(' class a extends b '));
        $stream->ignore(T_WHITESPACE);
        $this->assertEquals(T_CLASS, $stream->current()->type);
        $this->assertEquals(T_STRING, $stream->peek()->type);
        $this->assertEquals('a', $stream->peek()->value);
    }


    function testExpectReturnsMatchedTokenIfExpected() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('$var'));
        $tok = new Token(array(T_VARIABLE, '$var'));
        $this->assertEquals($tok, $stream->expect(T_VARIABLE));
    }

    /**
     * @expectedException UnexpectedValueException
     */
    function testExpectThrowsExceptionIfUnexpectedToken() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('$var'));
        $stream->expect(T_VAR);
    }

    /**
     * @expectedException LogicException
     */
    function testExpectThrowsExceptionIfEndOfStream() {
        $stream = new TokenStream(Tokenizer::tokenizePhp(''));
        $stream->expect(T_VAR);
    }



    function testMatchSignature() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('  /** DOC */ final public static function'));
        $this->assertTrue($stream->matchSignature(T_FUNCTION, null, array(T_DOC_COMMENT, T_FINAL, T_PUBLIC, T_STATIC)));
        $stream->expect(T_DOC_COMMENT);
    }


    function testToStringDoesNotAffectState() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('a b c'));
        $stream->next();
        $this->assertEquals(2, $stream->key());
        (string)$stream;
        $this->assertEquals(2, $stream->key());
    }


    function testSliceDoesNotAffectState() {
        $stream = new TokenStream(Tokenizer::tokenizePhp('a b c'));
        $stream->next();
        $this->assertEquals(2, $stream->key());
        $stream->slice(0);
        $this->assertEquals(2, $stream->key());
    }
}