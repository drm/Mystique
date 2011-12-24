<?php

namespace Mystique\PHP\Node;

class ElseNode extends BranchAbstract {
    function getNodeType()
    {
        return 'Else';
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('else');
        parent::compile($compiler);
    }


}