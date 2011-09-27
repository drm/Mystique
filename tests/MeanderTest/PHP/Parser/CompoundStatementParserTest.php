<?php
namespace Meander\PHP\Parser;

class CompoundStatementParserTest extends \MeanderTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/CompoundStatementParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new CompoundStatementParser(new PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}