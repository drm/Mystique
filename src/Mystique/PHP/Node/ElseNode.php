<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Compiler\CompilerInterface;

class ElseNode extends BranchAbstract {
    function getNodeType()
    {
        return 'Else';
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('else');
        parent::compile($compiler);
    }
}