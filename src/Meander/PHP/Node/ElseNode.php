<?php

namespace Meander\PHP\Node;

class ElseNode extends BranchAbstract {
    function getNodeType()
    {
        return 'Else';
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('else');
        parent::compile($compiler);
    }


}