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

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->compile($this->children[0]);
        $compiler->write('?');
        if(count($this->children) > 3) {
            $compiler->compile($this->children[2]);
            $compiler->write(':');
            $compiler->compile($this->children[3]);
        } else {
            $compiler->write(':');
            $compiler->compile($this->children[2]);
        }
    }
}