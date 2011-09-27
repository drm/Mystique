<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;

class BinaryExpression extends ExpressionAbstract 
{
    function __construct(Node $lValue, Operator $operator, Node $rValue, $parens = false)
    {
        parent::__construct();
        $this->children->append($lValue);
        $this->children->append($operator);
        $this->children->append($rValue);
        $this->setParens($parens);
    }


    function getLValue() {
        return $this->children[0];
    }


    function setLValue(Node $node) {
        $this->children[0] = $node;
    }


    function setRValue($node) {
        $this->children[2] = $node;
    }
    

    function setOperator($node) {
        $this->children[1] = $node;
    }

    
    function getRValue()
    {
        return $this->children[2];
    }

    
    function getOperator()
    {
        return $this->children[1];
    }
}