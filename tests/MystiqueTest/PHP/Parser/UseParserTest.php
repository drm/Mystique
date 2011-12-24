<?php
namespace Mystique\PHP\Parser;

class UseParserTest extends \MystiqueTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/UseParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new UseParser(new PhpParser());
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}