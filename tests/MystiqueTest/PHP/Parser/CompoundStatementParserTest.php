<?php
namespace Mystique\PHP\Parser;

class CompoundStatementParserTest extends \MystiqueTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/CompoundStatementParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new CompoundStatementParser(new PhpParser());
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}