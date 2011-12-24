<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;
use \Mystique\PHP\Token\Operator;

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