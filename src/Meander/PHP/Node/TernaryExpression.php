<?php
namespace Meander\PHP\Node;

use \Meander\PHP\Token\Operator;

class TernaryExpression extends BinaryExpression {
    function __construct(Node $test, Operator $operator, $lCase, Node $rCase) {
        if(is_null($lCase)) { // a ?: b
            parent::__construct($test, $operator, $rCase);
        } else { // a ? b : c
            parent::__construct($test, $operator, $lCase);
            $this->children->append($rCase);
        }
    }
}