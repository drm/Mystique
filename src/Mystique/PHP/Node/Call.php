<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\Node;

class Call extends Subscript {
    function __construct(Node $function, ExprList $arguments) {
        parent::__construct($function, $arguments);
    }

    function getOperator() {
        return new \Mystique\PHP\Token\Operator('(');
    }
}
