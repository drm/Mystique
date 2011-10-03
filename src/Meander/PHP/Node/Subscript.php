<?php

namespace Meander\PHP\Node;

class Subscript extends UnaryExpression {
    function __construct(Node $var, $subscript, \Meander\PHP\Token\Operator $type) {
        $this->children[0] = $var;
        $this->children[1] = $type;
        if($subscript) {
            $this->children[2] = $subscript;
        }
    }

    function getOperator() {
        return new \Meander\PHP\Token\Operator('[');
    }

    
    function getLeft() {
        return $this->children[0];
    }

    
    function setLeft($lValue) {
        $this->children[0] = $lValue;
    }
}
