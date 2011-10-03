<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;
use \Meander\PHP\Node\Node;

class UnaryExpression extends ExpressionAbstract implements \Meander\Compiler\Compilable
{
    function __construct(Operator $operator, Node $right, $parens = false)
    {
        parent::__construct();
        $this->setOperator($operator);
        $this->setRight($right);
        $this->setParens($parens);
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
}