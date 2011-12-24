<?php
namespace Mystique\PHP\Parser;

class PhpParserTest extends \MystiqueTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/PhpParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new PhpParser();
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenize($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}