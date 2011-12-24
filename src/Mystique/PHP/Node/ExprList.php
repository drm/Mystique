<?php

namespace Mystique\PHP\Node;
use \Mystique\Common\Compiler\CompilerInterface;

use Mystique\Common\Ast\Node\BranchAbstract;

class ExprList extends BranchAbstract implements \Mystique\Common\Compiler\Compilable {
    function compile(CompilerInterface $compiler) {
        $first = true;
        foreach($this->children as $node) {
            !$first and $compiler->write(',') or $first = false;
            $compiler->compile($node);
        }
    }
}