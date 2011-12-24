<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class Statement extends BranchAbstract {
    function __construct($e) {
        parent::__construct();
        if(!is_null($e)) {
            $this->children[0] = $e;
        }
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        parent::compile($compiler);
        $compiler->write(';');
    }
}