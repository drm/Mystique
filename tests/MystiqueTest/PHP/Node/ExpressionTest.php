<?php
namespace MystiqueTest\PHP\Node;
use \Mystique\PHP\Node\Variable;
use \Mystique\PHP\Node\Value;
use \Mystique\PHP\Token\Operator;
use Mystique\Common\Ast\Node\Expr\ExpressionAbstract;
use Mystique\Common\Ast\Node\Expr\BinaryExpression;
use Mystique\Common\Ast\Node\Expr\UnaryExpression;
use Mystique\Common\Ast\Node\Expr\ParenthesizedExpression;
use \Mystique\PHP\Node\Name;

use PHPUnit_Framework_TestCase;


class ExpressionTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->compiler = new \Mystique\Common\Compiler\Compiler();
    }


    function testBinaryExpression() {
        $this->assertEquals('$a&&$b', $this->compiler->compile(new BinaryExpression(new Variable('a'), new Operator('&&'), new Variable('b')))->result);
    }
    

    function testCompilationOfBinaryExpressionWithParentheses() {
        $expr = new ParenthesizedExpression(new BinaryExpression(
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
        \MystiqueTest\PHP\Assert::assertSyntaxEquals('new $b', $this->compiler->compile(new UnaryExpression(new Operator('new'), new Variable('b')))->result);
    }


    function testCompilationOfUnaryExpressionWithParentheses() {
        $expr = new ParenthesizedExpression(new UnaryExpression(
            new Operator('new'),
            new Name('\a\b\c')
        ));
        \MystiqueTest\PHP\Assert::assertSyntaxEquals(
            '(new \a\b\c)',
            $this->compiler->compile($expr)->result
        );
    }
}