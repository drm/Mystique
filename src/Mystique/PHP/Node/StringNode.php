<?php

namespace Mystique\PHP\Node;

class StringNode extends BranchAbstract {
    function getNodeType()
    {
        return 'String';
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('"');
        parent::compile($compiler);
        $compiler->write('"');
    }


}