<?php
namespace MystiqueTest\PHP\Parser;

use PHPUnit_Framework_TestCase;

abstract class AbstractParserIntegrationTest extends \MystiqueTest\TestCase {
    /**
     * @dataProvider readTestCasesFromFile
     */
    function testParserCases($code, $ast) {
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $this->getParser()->parse($stream);
        $this->assertASTEquals($ast, $node);
    }



    function readTestCasesFromFile() {
        $fn = __DIR__ . '/' . substr(get_class($this), strrpos(get_class($this), '\\') +1) . '.testcases';
        return $this->getCases($fn);
    }


    abstract function getParser();
}