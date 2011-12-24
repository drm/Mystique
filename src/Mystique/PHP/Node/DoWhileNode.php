<?php

namespace Mystique\PHP\Node;

class DoWhileNode extends WhileNode {
    function getNodeType()
    {
        return 'DoWhile';
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('do');
        $compiler->compile($this->children[1]);
        $compiler->write('while')->compile($this->children[0]);
    }
}