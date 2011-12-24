<?php

namespace Mystique\Common\Ast\Node\Expr;

use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;
use \Mystique\PHP\Token\Operator;
use Mystique\Common\Ast\Node\BranchAbstract;

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