<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;

abstract class ExpressionAbstract extends BranchAbstract implements Compilable {
    function compile(CompilerInterface $compiler) {
        if(!$this->children instanceof Compilable) {
            throw new \UnexpectedValueException("Unexpected children of type " . gettype($this->children) . ' in ' . get_class($this));
        }
        $this->children->compile($compiler);
    }

    abstract function getOperator();
    abstract function getRight();
}