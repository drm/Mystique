<?php

namespace MystiqueTest\PHP\Compiler;
use \Mystique\PHP\Compiler\XmlCompiler;

use PHPUnit_Framework_TestCase;

class XmlCompilerTest extends PHPUnit_Framework_TestCase {
    function testCompilation() {
        $compiler = new XmlCompiler();
        $walker = new \Mystique\PHP\Node\Traverser($compiler);
        $walker->traverse(new \Mystique\PHP\Node\BinaryExpression(new \Mystique\PHP\Node\Variable('a'), new \Mystique\PHP\Token\Operator('='), new \Mystique\PHP\Node\Value(10, \Mystique\PHP\Node\Value::T_INTEGER)));

        $this->assertXmlStringEqualsXmlString(
            '<ast><binary-expression><variable>a</variable><operator>=</operator><integer>10</integer></binary-expression></ast>',
            (string) $compiler
        );
    }
}