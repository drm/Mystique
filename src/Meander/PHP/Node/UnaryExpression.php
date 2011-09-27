<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;
use \Meander\PHP\Node\Node;

class UnaryExpression extends ExpressionAbstract implements \Meander\Compiler\Compilable
{
    function __construct(Operator $operator, Node $rValue, $parens = false)
    {
        parent::__construct();
        $this->setOperator($operator);
        $this->setRValue($rValue);
        $this->setParens($parens);
    }


    function getOperator()
    {
        return $this->children[0];
    }

    function getRValue()
    {
        return $this->children[1];
    }


    function setRValue(Node $value) {
        $this->children[1] = $value;
    }

    function setOperator($operator) {
        $this->children[0] = $operator;
    }
}