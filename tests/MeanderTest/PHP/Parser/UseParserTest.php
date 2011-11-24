<?php
namespace Meander\PHP\Parser;

class UseParserTest extends \MeanderTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/UseParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new UseParser(new PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}