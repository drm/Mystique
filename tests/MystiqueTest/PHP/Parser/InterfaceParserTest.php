<?php

namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\InterfaceParser;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Mystique\PHP\Parser\ClassParser
 */
class InterfaceParserTest extends AbstractParserIntegrationTest {
    function getParser() {
        return new InterfaceParser(new \Mystique\PHP\Parser\PhpParser());
    }
}