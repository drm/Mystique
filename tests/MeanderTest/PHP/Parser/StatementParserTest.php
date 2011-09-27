<?php
namespace Meander\PHP\Parser;

class StatementParserTest extends \MeanderTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/StatementParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new StatementParser(new PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        $this->assertFalse($stream->valid());
    }
}