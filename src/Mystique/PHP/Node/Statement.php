<?php

namespace Mystique\PHP\Node;

class Statement extends BranchAbstract {
    function __construct($e) {
        parent::__construct();
        if(!is_null($e)) {
            $this->children[0] = $e;
        }
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        parent::compile($compiler);
        $compiler->write(';');
    }
}