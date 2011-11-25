<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;

class ExprList extends BranchAbstract implements \Meander\Compiler\Compilable {
    function compile(CompilerInterface $compiler) {
        $first = true;
        foreach($this->children as $node) {
            !$first and $compiler->write(',') or $first = false;
            $compiler->compile($node);
        }
    }
}