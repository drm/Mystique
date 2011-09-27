<?php
namespace MeanderTest\PHP\Parser;

use \Meander\PHP\Parser\IfParser;
        
class IfParserTest extends \MeanderTest\TestCase {
    function expressions() {
        return $this->getCases(__DIR__.'/IfParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast) {
        $parser = new IfParser(new \Meander\PHP\Parser\PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
    }
}
