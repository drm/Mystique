<?php

namespace Meander\PHP\Node;

class StringNode extends BranchAbstract {
    function getNodeType()
    {
        return 'String';
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('"');
        parent::compile($compiler);
        $compiler->write('"');
    }


}