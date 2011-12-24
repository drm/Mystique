<?php
namespace Mystique\PHP\Parser;

class StatementParserTest extends \MystiqueTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/StatementParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new StatementParser(new PhpParser());
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        $this->assertFalse($stream->valid());
    }
}