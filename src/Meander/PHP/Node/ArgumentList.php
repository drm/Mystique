<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;
use Countable;

class ArgumentList extends BranchAbstract implements Countable {
    function compile(CompilerInterface $compiler) {
        $first = true;
        foreach($this->children as $node) {
            !$first and $compiler->write(',') or $first = false;
            $compiler->compile($node);
        }
    }


    function count() {
        return count($this->children);
    }
}