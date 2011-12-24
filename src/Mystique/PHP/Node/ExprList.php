<?php

namespace Mystique\PHP\Node;
use \Mystique\Compiler\CompilerInterface;

class ExprList extends BranchAbstract implements \Mystique\Compiler\Compilable {
    function compile(CompilerInterface $compiler) {
        $first = true;
        foreach($this->children as $node) {
            !$first and $compiler->write(',') or $first = false;
            $compiler->compile($node);
        }
    }
}