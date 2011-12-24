<?php

namespace Mystique\PHP\Node;

class Call extends Subscript {
    function __construct(Node $function, ExprList $arguments) {
        parent::__construct($function, $arguments);
    }

    function getOperator()
    {
        return new \Mystique\PHP\Token\Operator('(');
    }
}
