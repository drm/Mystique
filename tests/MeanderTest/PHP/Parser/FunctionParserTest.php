<?php


namespace MeanderTest\PHP\Parser;

class FunctionParserTest extends AbstractParserIntegrationTest {
    function getParser() {
        return new \Meander\PHP\Parser\FunctionParser(new \Meander\PHP\Parser\PhpParser());
    }
}