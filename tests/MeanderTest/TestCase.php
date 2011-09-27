<?php

namespace MeanderTest;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase {
    function assertASTEquals($ast, $node) {
        $compiler = new \Meander\PHP\Compiler\XmlCompiler();
        $walker = new \Meander\PHP\Node\Walker($compiler);
        $walker->walk($node);
        $this->assertXmlStringEqualsXmlString(
            $ast,
            (string)$compiler
        );
    }


    protected function getCases($file) {
        $f = file_get_contents($file);
        preg_match_all('/IN\n-+\s*(?P<in>.*?)\n-+\s*OUT\n-+\s*(?P<out>.*?)\n-+(\n|$)/s', $f, $m, PREG_SET_ORDER);
        $ret = array();
        foreach($m as $match) {
            $ret[]= array($match['in'], $match['out']);
        }
        return $ret;
    }

}