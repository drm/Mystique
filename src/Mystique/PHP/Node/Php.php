<?php

namespace Mystique\PHP\Node;

class Php extends BranchAbstract {
    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
        $compiler->write('<?php' . "\n\n");
        parent::compile($compiler);
    }
}