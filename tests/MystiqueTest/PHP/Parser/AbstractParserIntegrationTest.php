<?php
namespace MystiqueTest\PHP\Parser;

use PHPUnit_Framework_TestCase;

abstract class AbstractParserIntegrationTest extends \MystiqueTest\TestCase {
    /**
     * @dataProvider readTestCasesFromFile
     */
    function testParserCases($code, $ast) {
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $this->getParser()->parse($stream);
        $this->assertASTEquals($ast, $node);
    }


    abstract function getParser();
}