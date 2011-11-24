<?php
namespace MeanderTest\PHP\Parser;

use PHPUnit_Framework_TestCase;

abstract class AbstractParserIntegrationTest extends \MeanderTest\TestCase {
    /**
     * @dataProvider readTestCasesFromFile
     */
    function testParserCases($code, $ast) {
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $this->getParser()->parse($stream);
        $this->assertASTEquals($ast, $node);
    }



    function readTestCasesFromFile() {
        $fn = __DIR__ . '/' . substr(get_class($this), strrpos(get_class($this), '\\') +1) . '.testcases';
        return $this->getCases($fn);
    }


    abstract function getParser();
}