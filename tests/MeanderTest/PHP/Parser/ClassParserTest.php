<?php

namespace MeanderTest\PHP\Parser;

use \Meander\PHP\Parser\ClassParser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Meander\PHP\Parser\ClassParser
 */
class ClassParserTest extends \MeanderTest\TestCase {
    function testParseSimpleDeclaration() {
        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a {}')));
        $this->assertFalse($classDef->isFinal());
        $this->assertFalse($classDef->isAbstract());
        $this->assertNull($classDef->getDoc());
        $this->assertEquals('a', (string)$classDef->getName());
    }


//    function testDocComment() {
//        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
//        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
//        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('/** Awesomeness! */ class a {}')));
//        $this->assertEquals(new \Meander\PHP\Node\DocBlock('/** Awesomeness! */'), $classDef->getDoc());
//    }

    function testFinal() {
        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('final class a {}')));
        $this->assertTrue($classDef->isFinal());
    }


    function testAbstract() {
        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('abstract class a {}')));
        $this->assertTrue($classDef->isAbstract());
    }


    function testExtends() {
        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a extends b {}')));
        $this->assertEquals('b', (string)$classDef->getExtends());
    }


    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new ClassParser(new \Meander\PHP\Parser\PhpParser());
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        if($stream->valid()) {
            $this->fail("Stream did not reach end of data, " . $stream->current()->verbose(). " was found");
        }
    }
    function parserCases() {
        return $this->getCases(__DIR__.'/ClassParserTest.testcases');
    }
}