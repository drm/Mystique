<?php
namespace Mystique\PHP\Parser;

class CompoundStatementParserTest extends \MystiqueTest\PHP\Parser\AbstractParserIntegrationTest {
    public function getParser() {
        return new CompoundStatementParser(new PhpParser());
    }
}