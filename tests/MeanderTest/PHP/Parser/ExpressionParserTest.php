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
        $p = new ExpressionParser(new BodyParser());
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
        $parser = new ExpressionParser(new BodyParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        if($stream->valid()) {
            $this->fail("Stream did not reach end of data, " . $stream->current()->verbose(). " was found");
        }
    }
}