<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

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