<?php

namespace Meander\PHP\Node;

class CompoundStatement extends \Meander\PHP\Node\BranchAbstract {
    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}