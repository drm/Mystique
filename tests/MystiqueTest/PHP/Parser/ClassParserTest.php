<?php

namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\ClassParser;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Mystique\PHP\Parser\ClassParser
 */
class ClassParserTest extends \MystiqueTest\TestCase {
    function testParseSimpleDeclaration() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a {}')));
        $this->assertFalse($classDef->isFinal());
        $this->assertFalse($classDef->isAbstract());
        $this->assertNull($classDef->getDocBlock());
        $this->assertEquals('a', (string)$classDef->getName());
    }


    function testGetDocBlock() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('/** documentation */ class a {}')));
        $this->assertEquals('/** documentation */', $classDef->getDocBlock());
    }


//    function testDocComment() {
//        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
//        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
//        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('/** Awesomeness! */ class a {}')));
//        $this->assertEquals(new \Mystique\PHP\Node\DocBlock('/** Awesomeness! */'), $classDef->getDoc());
//    }

    function testFinal() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('final class a {}')));
        $this->assertTrue($classDef->isFinal());
    }


    function testAbstract() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('abstract class a {}')));
        $this->assertTrue($classDef->isAbstract());
    }


    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        $stream = new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
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