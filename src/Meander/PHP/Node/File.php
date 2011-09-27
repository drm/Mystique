<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;

class File extends RootNode {
    function compile(CompilerInterface $compiler)
    {
        $compiler->write('<?php');
        parent::compile($compiler);
    }
}