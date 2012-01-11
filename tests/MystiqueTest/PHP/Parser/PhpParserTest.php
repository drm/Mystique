<?php
namespace Mystique\PHP\Parser;

class PhpParserTest extends \MystiqueTest\PHP\Parser\AbstractParserIntegrationTest {
    protected $isFullParser = true;

    function getParser() {
        return new PhpParser();
    }
}