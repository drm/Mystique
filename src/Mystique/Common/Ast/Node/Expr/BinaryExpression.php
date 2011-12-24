<?php
namespace Mystique\Common\Ast\Node\Expr;

use \Mystique\Common\Compiler\CompilerInterface;
use \Mystique\PHP\Token\Operator;
use Mystique\Common\Ast\Node\Node;

class BinaryExpression extends ExpressionAbstract
{
    function __construct(Node $left, Operator $operator, Node $right)
    {
        parent::__construct();
        $this->setLeft($left);
        $this->setOperator($operator);
        $this->setRight($right);
    }

    function setRight(Node $value)
    {
        $this->children[2] = $value;
    }

    function getRight()
    {
        return $this->children[2];
    }


    function setOperator($operator) {
        $this->children[1]= $operator;
    }

    function getOperator(){
        return $this->children[1];
    }


    function setLeft($node) {
        $this->children[0] = $node;
    }
    

    function getLeft() {
        return $this->children[0];
    }
}