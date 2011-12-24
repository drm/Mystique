<?php

namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\ClosureParser;
use \Mystique\PHP\Token\TokenStream;
use \Mystique\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Mystique\PHP\Parser\ClassParser
 */
class ClosureParserTest extends \MystiqueTest\TestCase {
    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new ClosureParser(new BodyParser);
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
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
        $this->assertTrue($parser->match(new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp('function () {}'))));
        $this->assertFalse($parser->match(new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp('function x () {}'))));
    }
}