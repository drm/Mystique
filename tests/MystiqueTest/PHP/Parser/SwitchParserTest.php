<?php
namespace Mystique\PHP\Parser;

class SwitchParserTest extends \MystiqueTest\TestCase
{
    function expressions()
    {
        return $this->getCases(__DIR__ . '/SwitchParserTest.testcases');
    }

    /**
     * @dataProvider expressions
     */
    function testParser($code, $ast)
    {
        $parser = new SwitchParser(new PhpParser());
        $stream = new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        $this->assertFalse($stream->valid());
    }
}