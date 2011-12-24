<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class StringNode extends BranchAbstract {
    function getNodeType()
    {
        return 'String';
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('"');
        parent::compile($compiler);
        $compiler->write('"');
    }


}