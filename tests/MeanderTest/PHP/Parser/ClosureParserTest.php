<?php

namespace MeanderTest\PHP\Parser;

use \Meander\PHP\Parser\ClosureParser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Meander\PHP\Parser\ClassParser
 */
class ClosureParserTest extends \MeanderTest\TestCase {
    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new ClosureParser(new BodyParser);
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        if($stream->valid()) {
            $this->fail("Stream did not reach end of data, " . $stream->current()->verbose(). " was found");
        }
    }
    function parserCases() {
        return $this->getCases(__DIR__.'/ClosureParserTest.testcases');
    }


    function testMatching() {
        $parser = new ClosureParser(new BodyParser);
        $this->assertTrue($parser->match(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp('function () {}'))));
        $this->assertFalse($parser->match(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp('function x () {}'))));
    }
}