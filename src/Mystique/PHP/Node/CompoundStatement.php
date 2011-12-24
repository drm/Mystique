<?php

namespace Mystique\PHP\Node;

class CompoundStatement extends \Mystique\PHP\Node\BranchAbstract {
    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}