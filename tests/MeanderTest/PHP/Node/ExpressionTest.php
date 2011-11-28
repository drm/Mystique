<?php
namespace MeanderTest\PHP\Node;
use \Meander\PHP\Node\Variable;
use \Meander\PHP\Node\Value;
use \Meander\PHP\Token\Operator;
use \Meander\PHP\Node\ExpressionAbstract;
use \Meander\PHP\Node\BinaryExpression;
use \Meander\PHP\Node\UnaryExpression;
use \Meander\PHP\Node\Name;

use PHPUnit_Framework_TestCase;


class ExpressionTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->compiler = new \Meander\Compiler\Compiler();
    }


    function testBinaryExpression() {
        $this->assertEquals('$a&&$b', $this->compiler->compile(new BinaryExpression(new Variable('a'), new Operator('&&'), new Variable('b')))->result);
    }
    

    function testCompilationOfBinaryExpressionWithParentheses() {
        $expr = new \Meander\PHP\Node\ParenthesizedExpression(new BinaryExpression(
            new Variable('a'),
            new Operator('&&'),
            new Variable('b')
        ));
        $this->assertEquals(
            '($a&&$b)',
            $this->compiler->compile($expr)->result
        );
    }


    function testCompilationOfBinaryExpressionComposite() {
        $this->assertEquals(
            '$a&&$a/2',
            $this->compiler->compile(
                new BinaryExpression(
                    new Variable('a'),
                    new Operator('&&'),
                    new BinaryExpression(new Variable('a'), new Operator('/'), new Value(2, Value::T_INTEGER))
                )
            )->result
        );
    }


    function testCompilationOfUnaryExpression() {
        \MeanderTest\PHP\Assert::assertSyntaxEquals('new $b', $this->compiler->compile(new UnaryExpression(new Operator('new'), new Variable('b')))->result);
    }


    function testCompilationOfUnaryExpressionWithParentheses() {
        $expr = new \Meander\PHP\Node\ParenthesizedExpression(new UnaryExpression(
            new Operator('new'),
            new Name('\a\b\c')
        ));
        \MeanderTest\PHP\Assert::assertSyntaxEquals(
            '(new \a\b\c)',
            $this->compiler->compile($expr)->result
        );
    }
}