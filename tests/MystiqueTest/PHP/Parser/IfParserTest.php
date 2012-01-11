<?php
namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\IfParser;
        
class IfParserTest extends AbstractParserIntegrationTest {
    function getParser() {
        return new IfParser(new \Mystique\PHP\Parser\PhpParser());
    }
}
