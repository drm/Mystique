<?php
namespace Meander\PHP\Parser;

class SwitchParserTest extends \MeanderTest\TestCase
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
        $stream = new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($code));
        $node = $parser->parse($stream);
        $this->assertASTEquals($ast, $node);
        $this->assertFalse($stream->valid());
    }
}