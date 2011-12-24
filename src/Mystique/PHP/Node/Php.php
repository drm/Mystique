<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class Php extends BranchAbstract {
    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->write('<?php' . "\n\n");
        parent::compile($compiler);
    }
}