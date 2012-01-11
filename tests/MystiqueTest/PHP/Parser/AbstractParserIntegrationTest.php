<?php
namespace MystiqueTest\PHP\Parser;

use PHPUnit_Framework_TestCase;
use Mystique\PHP\Lang as Php;

abstract class AbstractParserIntegrationTest extends \MystiqueTest\TestCase {
    protected $isFullParser = false;

    /**
     * @dataProvider readTestCasesFromFile
     */
    function testParserCases($code, $ast) {
        if($this->isFullParser) {
            $stream = Php::tokenStream($code);
        } else {
            $stream = Php::tokenStreamPhp($code);
        }
        $node = $this->getParser()->parse($stream);
        $this->assertASTEquals($ast, $node);
    }


    abstract function getParser();
}