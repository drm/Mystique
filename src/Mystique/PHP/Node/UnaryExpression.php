<?php
namespace Mystique\PHP\Node;

use \Mystique\Compiler\CompilerInterface;
use \Mystique\PHP\Token\Operator;
use \Mystique\PHP\Node\Node;

class UnaryExpression extends ExpressionAbstract implements \Mystique\Compiler\Compilable
{
    function __construct(Operator $operator, Node $right)
    {
        parent::__construct();
        $this->setOperator($operator);
        $this->setRight($right);
    }


    function setOperator($operator) {
        $this->children[0]= $operator;
    }


    function getOperator()
    {
        return $this->children[0];
    }


    function getRight()
    {
        return $this->children[1];
    }


    function setRight(Node $value) {
        $this->children[1] = $value;
    }


    function setLeft($value) {
        $this->setRight($value);
    }

    function getLeft() {
        return $this->getRight();
    }
}