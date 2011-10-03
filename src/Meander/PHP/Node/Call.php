<?php

namespace Meander\PHP\Node;

class Call extends Subscript {
    function __construct(Node $function, ExprList $arguments) {
        $this->children[0] = $function;
        if(count($arguments)) {
            $this->children[1] = $arguments;
        }
    }

    function getOperator() {
        return new \Meander\PHP\Token\Operator('[');
    }
}
