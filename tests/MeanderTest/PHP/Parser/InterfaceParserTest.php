<?php

namespace MeanderTest\PHP\Parser;

use \Meander\PHP\Parser\InterfaceParser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Meander\PHP\Parser\ClassParser
 */
class InterfaceParserTest extends \MeanderTest\TestCase {
    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new InterfaceParser(new \Meander\PHP\Parser\PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        if($stream->valid()) {
            $this->fail("Stream did not reach end of data, " . $stream->current()->verbose(). " was found");
        }
    }
    function parserCases() {
        return $this->getCases(__DIR__.'/InterfaceParserTest.testcases');
    }
}