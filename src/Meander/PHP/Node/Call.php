<?php

namespace Meander\PHP\Node;

class Call extends Subscript {
    function __construct(Node $function, ExprList $arguments) {
        parent::__construct($function, $arguments);
    }

    function getOperator()
    {
        return new \Meander\PHP\Token\Operator('(');
    }
}
