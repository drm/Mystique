<?php

namespace Mystique\PHP\Node;
use \Mystique\Compiler\CompilerInterface;

class File extends RootNode {
    function compile(CompilerInterface $compiler)
    {
        $compiler->write('<?php');
        parent::compile($compiler);
    }
}