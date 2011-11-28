<?php

namespace Meander\PHP\Node;

class Php extends BranchAbstract {
    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('<?php' . "\n\n");
        parent::compile($compiler);
    }
}