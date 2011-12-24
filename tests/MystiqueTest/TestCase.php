<?php

namespace MystiqueTest;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    function assertASTEquals($ast, $node)
    {
        $compiler = new \Mystique\PHP\Compiler\XmlCompiler();
        $walker = new \Mystique\PHP\Node\Traverser($compiler);
        $walker->traverse($node);
        $this->assertXmlStringEqualsXmlString(
            $ast,
            (string)$compiler
        );
    }


    function assertSyntaxEquals($a, $b, $message = 'Failed asserting that two pieces of code are equal') {
        return \MystiqueTest\PHP\Assert::assertSyntaxEquals($a, $b, $message);
    }


    protected function getCases($file)
    {
        if (!is_file($file)) {
            $this->markTestIncomplete("File does not exist: $file");
        }
        $f = file_get_contents($file);
        preg_match_all('/IN\n-+\s*(?P<in>.*?)\n-+\s*OUT\n-+\s*(?P<out>.*?)\n-+(\n|$)/s', $f, $m, PREG_SET_ORDER);
        $ret = array();
        foreach ($m as $match) {
            $ret[] = array($match['in'], $match['out']);
        }
        return $ret;
    }
}