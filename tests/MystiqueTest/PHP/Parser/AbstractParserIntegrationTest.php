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
        $l = new Php();
        if($this->isFullParser) {
            $stream = $l->getTokenStream($code);
        } else {
            $stream = $l->getTokenStream($code, null, '');
        }
        $node = $this->getParser()->parse($stream);
        $this->assertASTEquals($ast, $node);
    }


    abstract function getParser();
}