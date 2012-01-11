<?php
namespace Mystique\PHP\Parser;

class UseParserTest extends \MystiqueTest\PHP\Parser\AbstractParserIntegrationTest {
    function getParser() {
        return new UseParser(new PhpParser());
    }
}