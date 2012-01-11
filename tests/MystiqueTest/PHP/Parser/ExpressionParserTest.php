<?php

namespace MystiqueTest\PHP\Parser;

use PHPUnit_Framework_TestCase;
use \Mystique\PHP\Parser\ExpressionParser;
use \Mystique\PHP\Node;
use \Mystique\PHP\Node\UnaryExpression as U;
use \Mystique\PHP\Node\BinaryExpression as B;
use \Mystique\PHP\Token\Token;
use \Mystique\PHP\Token\Operator;
use DOMDocument;


class ExpressionParserTest extends AbstractParserIntegrationTest {
    /**
     * @dataProvider arglists
     */
    function testParseArgumentList($arglist, $allowEmpty = false, $ast = null) {
        $p = new ExpressionParser(new BodyParser());
        $stream = \Mystique\PHP\Lang::tokenStreamPhp($arglist);
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
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($strName));
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
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($strName));
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


    function getParser() {
        return new ExpressionParser(new BodyParser());
    }
}