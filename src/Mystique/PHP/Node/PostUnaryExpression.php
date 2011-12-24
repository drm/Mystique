<?php
namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\CompilerInterface;
use \Mystique\PHP\Token\Operator;
use Mystique\Common\Ast\Node\Expr\ExpressionAbstract;
use Mystique\Common\Ast\Node\Node;
use Mystique\Common\Compiler\Compilable;

class PostUnaryExpression extends ExpressionAbstract implements Compilable
{
    function __construct(Operator $operator, Node $right)
    {
        parent::__construct();
        $this->setRight($right);
        $this->setOperator($operator);
    }


    function setOperator($operator) {
        $this->children[1]= $operator;
    }


    function getOperator()
    {
        return $this->children[1];
    }


    function getRight()
    {
        return $this->children[0];
    }


    function setRight(Node $value) {
        $this->children[0] = $value;
    }


    function setLeft($value) {
        $this->setRight($value);
    }

    function getLeft() {
        return $this->getRight();
    }

    function getNodeType()
    {
        return 'UnaryExpression';
    }
}