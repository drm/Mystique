<?php

namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\ClosureParser;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Mystique\PHP\Parser\ClassParser
 */
class ClosureParserTest extends AbstractParserIntegrationTest {
    function getParser() {
        return new ClosureParser(new BodyParser);
    }

    function testMatching() {
        $parser = new ClosureParser(new BodyParser);
        $this->assertTrue($parser->match(\Mystique\PHP\Lang::tokenStreamPhp('function () {}')));
        $this->assertFalse($parser->match(\Mystique\PHP\Lang::tokenStreamPhp('function x () {}')));
    }
}