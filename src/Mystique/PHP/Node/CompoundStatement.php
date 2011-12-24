<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;

class CompoundStatement extends BranchAbstract {
    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}