<?php

namespace MystiqueTest\Annotation\Token;

use Mystique\Annotation\Token\Tokenizer;
use PHPUnit_Framework_TestCase;

class TokenizerTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider strings
     */
    function testTokenizer($in, $expectTypes, $expectValues) {
        $tokenizer = new Tokenizer();
        $tokens = $tokenizer->getTokens($in);
        $this->assertEquals($expectTypes, array_map(function($tok) { return $tok->type; }, $tokens));
        $this->assertEquals($expectValues, array_map(function($tok) { return $tok->value; }, $tokens));
    }


    function strings() {
        return array(
            array(
                '""',
                array('string'),
                array('""'),
            ),
            array(
                '0',
                array('number'),
                array('0'),
            ),
            array(
                '0xa',
                array('number'),
                array('0xa'),
            ),
            array(
                '0.1',
                array('number'),
                array('0.1'),
            ),
            array(
                '.1',
                array('number'),
                array('.1'),
            ),
            array(
                '007',
                array('number'),
                array('007'),
            ),
            array(
                '"\\"',
                array('string'),
                array('"\\"'),
            ),
            array(
                '"string"',
                array('string'),
                array('"string"'),
            ),
            array(
                '@If("string")',
                array('@', 'name', '(', 'string', ')'),
                array('@', 'If', '(', '"string"', ')')
            ),
            array(
                '@If("str\\ng")',
                array('@', 'name', '(', 'string', ')'),
                array('@', 'If', '(', '"str\\ng"', ')')
            ),
            array(
                '@If(name="string")',
                array('@', 'name', '(', 'name', '=', 'string', ')'),
                array('@', 'If', '(', 'name', '=', '"string"', ')')
            ),
            array(
                '@If({name="string"})',
                array('@', 'name', '(', '{', 'name', '=', 'string', '}', ')'),
                array('@', 'If', '(', '{', 'name', '=', '"string"', '}', ')')
            ),
            array(
                '@If ( ) ',
                array('@', 'name', 'whitespace', '(', 'whitespace', ')', 'whitespace'),
                array('@', 'If', ' ', '(', ' ', ')', ' '),
            ),
        );
    }
}