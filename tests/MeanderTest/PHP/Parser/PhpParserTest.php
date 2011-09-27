<?php
namespace Meander\PHP\Parser;

class PhpParserTest extends \MeanderTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/PhpParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new PhpParser();
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenize($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}