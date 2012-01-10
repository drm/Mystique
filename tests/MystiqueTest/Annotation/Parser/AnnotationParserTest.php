<?php

namespace MystiqueTest\Annotation\Parser;

use Mystique\Annotation\Token\Tokenizer;
use Mystique\Annotation\Parser\AnnotationParser;
use PHPUnit_Framework_TestCase;

class AnnotationParserTest extends \MystiqueTest\TestCase {
    function setUp() {
        $this->tokenizer = new Tokenizer();
        $this->parser = new AnnotationParser();
    }


    /**
     * @dataProvider readTestCasesFromFile
     */
    function testAnnotationParser($in, $out) {
        $this->assertASTEquals($out, $this->parser->parse(new \Mystique\Common\Token\TokenStream($this->tokenizer->getTokens($in), array('whitespace'))));
    }
}