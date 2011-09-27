<?php

namespace Meander\PHP\Node;

class Call extends UnaryExpression {
    function __construct(Node $function, ArgumentList $arguments) {
        $this->children[0] = $function;
        if(count($arguments)) {
            $this->children[1] = $arguments;
        }
    }

    function getOperator() {
        return new \Meander\PHP\Token\Operator('[');
    }

    
    function getLValue() {
        return $this->children[0];
    }

    
    function setLValue($lValue) {
        $this->children[0] = $lValue;
    }
}
