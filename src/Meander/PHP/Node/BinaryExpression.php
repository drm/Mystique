<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;

class BinaryExpression extends ExpressionAbstract
{

    function __construct(Node $left, Operator $operator, Node $right, $parens = false)
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