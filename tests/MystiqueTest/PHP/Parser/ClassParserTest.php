<?php

namespace MystiqueTest\PHP\Parser;

use \Mystique\PHP\Parser\ClassParser;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;

use \Mystique\PHP\Lang as Php;


/**
 * @covers \Mystique\PHP\Parser\ClassParser
 */
class ClassParserTest extends \MystiqueTest\TestCase {
    function testParseSimpleDeclaration() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a {}'), array(T_DOC_COMMENT, T_COMMENT, T_WHITESPACE)));
        $this->assertFalse($classDef->isFinal());
        $this->assertFalse($classDef->isAbstract());
        $this->assertEquals('a', (string)$classDef->getName());
    }



    function testFinal() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(Php::tokenStreamPhp('final class a {}'));
        $this->assertTrue($classDef->isFinal());
    }


    function testAbstract() {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        /** @var \ClassNode\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(Php::tokenStreamPhp('abstract class a {}'));
        $this->assertTrue($classDef->isAbstract());
    }


    /**
     * @dataProvider parserCases
     */
    function testParserCases($code, $ast) {
        $parser = new ClassParser(new \Mystique\PHP\Parser\PhpParser());
        $stream = Php::tokenStreamPhp($code);
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