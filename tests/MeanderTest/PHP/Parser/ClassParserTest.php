<?php

namespace MeanderTest\PHP\Parser;

use \Meander\PHP\Parser\ClassParser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Tokenizer;
use PHPUnit_Framework_TestCase;


/**
 * @covers \Meander\PHP\Parser\ClassParser
 */
class ClassParserTest extends PHPUnit_Framework_TestCase {
    function testParseSimpleDeclaration() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a {}')));
        $this->assertFalse($classDef->isFinal());
        $this->assertFalse($classDef->isAbstract());
        $this->assertNull($classDef->getDoc());
        $this->assertEquals('a', (string)$classDef->getName());
    }


    function testDocComment() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('/** Awesomeness! */ class a {}')));
        $this->assertEquals('/** Awesomeness! */', $classDef->getDoc());
    }

    function testFinal() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('final class a {}')));
        $this->assertTrue($classDef->isFinal());
    }


    function testAbstract() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('abstract class a {}')));
        $this->assertTrue($classDef->isAbstract());
    }


    function testExtends() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a extends b {}')));
        $this->assertEquals('b', (string)$classDef->getExtends());
    }


    function testImplementsOne() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a implements i1 {}')));
        $this->assertEquals('i1', implode('|', $classDef->getImplements()));
    }


    function testImplementsMul() {
        $parser = new ClassParser();
        /** @var \Meander\PHP\Node\ClassDefinition $classDef */
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a implements i1, i2, i3 {}')));
        $this->assertEquals('i1|i2|i3', implode('|', $classDef->getImplements()));
    }


    function testRawBody() {
        $parser = new ClassParser();
        $classDef = $parser->parse(new TokenStream(Tokenizer::tokenizePhp('class a { /* raw body */ function __construct() {} } ')));
        $compiler = new \Meander\Compiler\Compiler();
        $this->assertEquals('{ /* raw body */ function __construct() {} }', $compiler->compile($classDef->getRawBody())->result);
    }
}