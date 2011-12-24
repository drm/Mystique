<?php


namespace MystiqueTest\PHP\Parser;

class FunctionParserTest extends AbstractParserIntegrationTest {
    function getParser() {
        return new \Mystique\PHP\Parser\FunctionParser(new \Mystique\PHP\Parser\PhpParser());
    }
}