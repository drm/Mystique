<?php
namespace Mystique\PHP\Parser;

class StatementParserTest extends \MystiqueTest\PHP\Parser\AbstractParserIntegrationTest {
    function getParser() {
        return new StatementParser(new PhpParser());
    }
}