<?php
namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\IfParser;
        
class IfParserTest extends \MystiqueTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/IfParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new IfParser(new \Mystique\PHP\Parser\PhpParser());
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}
