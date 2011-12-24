<?php

namespace MystiqueTest\PHP\Compiler;

use Mystique\Common\Ast\AstToXml;
use Mystique\Common\Ast\Traverser;
use PHPUnit_Framework_TestCase;
use Mystique\Common\Ast\Node\Expr\BinaryExpression;

class AstToXmlTest extends PHPUnit_Framework_TestCase {
    function testCompilation() {
        $compiler = new AstToXml();
        $walker = new Traverser($compiler);
        $walker->traverse(new BinaryExpression(new \Mystique\PHP\Node\Variable('a'), new \Mystique\PHP\Token\Operator('='), new \Mystique\PHP\Node\Value(10, \Mystique\PHP\Node\Value::T_INTEGER)));

        $this->assertXmlStringEqualsXmlString(
            '<ast><binary-expression><variable>a</variable><operator>=</operator><integer>10</integer></binary-expression></ast>',
            (string) $compiler
        );
    }
}