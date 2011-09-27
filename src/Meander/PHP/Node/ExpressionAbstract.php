<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;
use \Meander\PHP\Token\Operator;

abstract class ExpressionAbstract extends BranchAbstract implements Compilable {
    function compile(CompilerInterface $compiler) {
        $this->parens && $compiler->write('(');
        $this->children->compile($compiler);
        $this->parens && $compiler->write(')');
    }

    abstract function getOperator();
    abstract function getRValue();
}