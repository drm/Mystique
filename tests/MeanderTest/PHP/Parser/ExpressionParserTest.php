<?php

namespace MeanderTest\PHP\Parser;

use PHPUnit_Framework_TestCase;
use \Meander\PHP\Parser\ExpressionParser;
use \Meander\PHP\Node;
use \Meander\PHP\Node\UnaryExpression as U;
use \Meander\PHP\Node\BinaryExpression as B;
use \Meander\PHP\Token\Token;
use \Meander\PHP\Token\Operator;
use DOMDocument;


class ExpressionParserTest extends \MeanderTest\TestCase {
    /**
     * @dataProvider arglists
     */
    function testParseArgumentList($arglist, $allowEmpty = false, $ast = null) {
        $p = new ExpressionParser();
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($arglist));
        $stream->expect('(');
        $list = $p->parseList($stream, $allowEmpty);
        $stream->expect(')');
        $this->assertFalse($stream->valid());
        if(!is_null($ast)) {
            $this->assertASTEquals('<ast>' . $ast . '</ast>', $list);
        }
    }
    function arglists() {
        return array(
            array('($a)'),
            array('($a, fn())'),
            array('(,)', true, '<expr-list><noop /><noop /></expr-list>'),
            array('(,,,,,)', true, '<expr-list><noop /><noop /><noop /><noop /><noop /><noop /></expr-list>'),
            array('($a,)', true, '<expr-list><variable>a</variable><noop /></expr-list>'),
            array('(,$a)', true, '<expr-list><noop /><variable>a</variable></expr-list>'),
        );
    }


    /**
     * @dataProvider names
     */
    function testParseName($strName) {
        $p = new ExpressionParser();
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($strName));
        $p->parseName($stream);
        $this->assertFalse($stream->valid());
    }
    function names() {
        return array(
            array('\\absolute'),
            array('\\absolute\\name'),
            array('local'),
            array('relative\\name'),
        );
    }


    /**
     * @dataProvider values
     */
    function testParseValue($strName) {
        $p = new ExpressionParser();
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($strName));
        $p->parseValue($stream);
        $this->assertFalse($stream->valid());
    }
    function values() {
        return array(
            array('\\absolute'),
            array('\\absolute\\name'),
            array('local'),
            array('relative\\name'),
            array('1'),
            array('"w00t"'),
            array('true'),
            array('false'),
            array('$var'),
        );
    }


    function expressions() {
        return $this->getCases(__DIR__.'/ExpressionParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new ExpressionParser();
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        if($stream->valid()) {
            $this->fail("Stream did not reach end of data, " . $stream->current()->verbose(). " was found");
        }
    }

//    /**
//     * @dataProvider expressions2
//     */
//    function testParse2($expect, $code) {
//        $parser = new ExpressionParser();
//        $node = $parser->parse(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code)));
//        $this->assertEquals($expect, $node);
//    }
//    function expressions2() {
//        $ret = array();
//        $ret[]=array(new Node\Variable('a'), '$a');
//        $ret[]=array(new Node\Value(null), 'null');
//        $ret[]=array(new Node\Value(false), 'false');
//        $ret[]=array(new Node\Value(true), 'true');
//        $ret[]=array(new Node\Value(1), '1');
//        $ret[]=array(new Node\Value(1.1), '1.1');
//        $ret[]=array(new Node\Value('some string'), '"some string"');
//        $ret[]=array(
//            new U(new Operator('-'), new U(new Operator(array(T_DEC, '--')), new Node\Variable('i'))),
//            '- --$i'
//        );
//        $ret[]=array(
//            new B(new U(new Operator(array(T_NEW, 'new')), new Node\Name('A')), new Operator(array(T_IS_EQUAL, '==')), new Node\Value('w00t')),
//            'new A == "w00t"'
//        );
//        $ret[]=array(
//            new B(new U(new Operator(array(T_NEW, 'new')), new Node\Name('A')), new Operator(array(T_IS_EQUAL, '==')), new Node\Value('w00t'), true),
//            '(new A == "w00t")'
//        );
//        $ret[]=array(
//            new U(new Operator(array(T_NEW, 'new')), new B(new Node\Name('A'), new Operator(array(T_IS_EQUAL, '==')), new Node\Value('w00t'), true)),
//            'new (A == "w00t")'
//        );
//        $ret[]=array(
//            new B(
//                new Node\Variable('a'),
//                new Operator(array(T_LOGICAL_AND, 'and')),
//                new B(
//                    new Node\Variable('b'),
//                    new Operator(array(T_BOOLEAN_OR, '||')),
//                    new Node\Variable('c')
//                )
//            ),
//            '$a and $b || $c'
//        );
//        $ret[]=array(
//            new B(
//                new B(
//                    new Node\Variable('a'),
//                    new Operator(array(T_BOOLEAN_AND, '&&')),
//                    new Node\Variable('b')
//                ),
//                new Operator(array(T_LOGICAL_OR, 'or')),
//                new Node\Variable('c')
//            ),
//            '$a && $b or $c'
//        );
//        $ret[]=array(
//            new B(
//                new B(
//                    new Node\Variable('a'),
//                    new Operator(array(T_BOOLEAN_AND, '&&')),
//                    new Node\Variable('b')
//                ),
//                new Operator(array(T_BOOLEAN_OR, '||')),
//                new Node\Variable('c')
//            ),
//            '$a && $b || $c'
//        );
//        $ret[]=array(
//            new B(
//                new B(
//                    new Node\Variable('a'),
//                    new Operator(array(T_BOOLEAN_AND, '&&')),
//                    new Node\Variable('b')
//                ),
//                new Operator(array(T_BOOLEAN_OR, '||')),
//                new Node\Variable('c')
//            ),
//            '$a && $b || $c'
//        );
//        $ret[]=array(
//            new U(
//                new Operator('!'),
//                new B(
//                    new B(
//                        new Node\Variable('a'),
//                        new Operator(array(T_BOOLEAN_AND, '&&')),
//                        new Node\Variable('b')
//                    ),
//                    new Operator(array(T_BOOLEAN_OR, '||')),
//                    new Node\Variable('c'),
//                    true
//                )
//            ),
//            '!($a && $b || $c)'
//        );
//
//        $ret[]=array(
//            new B(
//                new B(
//                    new Node\Variable('a'),
//                    new Operator('*'),
//                    new Node\Variable('b')
//                ),
//                new Operator('-'),
//                new Node\Variable('c')
//            ),
//            '$a * $b - $c'
//        );
//        $ret[]=array(
//            new B(
//                new Node\Variable('c'),
//                new Operator('-'),
//                new B(
//                    new Node\Variable('a'),
//                    new Operator('*'),
//                    new Node\Variable('b')
//                )
//            ),
//            '$c - $a * $b'
//        );
//        $ret[]=array(
//            new B(
//                new Node\Variable('a'),
//                new Operator(array(T_SL, '<<')),
//                new B(
//                    new Node\Variable('b'),
//                    new Operator('*'),
//                    new B(
//                        new Node\Variable('a'),
//                        new Operator('*'),
//                        new Node\Variable('b')
//                    )
//                )
//            ),
//            '$a << $b * $a * $b'
//        );
//        $ret[]=array(
//            new B(
//                new Node\Variable('a'),
//                new Operator(array(T_SL, '<<')),
//                new B(
//                    new Node\Variable('b'),
//                    new Operator(array(T_SL, '<<')),
//                    new B(
//                        new Node\Variable('a'),
//                        new Operator('*'),
//                        new Node\Variable('b')
//                    )
//                )
//            ),
//            '$a << $b << $a * $b'
//        );
//
//        $ret[]=array(
//            new B(
//                new B(
//                    new Node\Variable('c'),
//                    new Operator('-'),
//                    new B(
//                        new Node\Variable('a'),
//                        new Operator('*'),
//                        new Node\Variable('b')
//                    )
//                ),
//                new Operator(array(T_SL, '<<')),
//                new Node\Value(3)
//            ),
//            '$c - $a * $b << 3'
//        );
//        return $ret;
//    }
}