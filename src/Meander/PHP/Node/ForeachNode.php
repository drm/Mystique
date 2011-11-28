<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
class ForeachNode extends ForNode {
    function getNodeType()
    {
        return 'Foreach';
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('foreach')->write('(');
        $compiler->compile($this->children[0]);
        $compiler->write('as');
        $compiler->compile($this->children[1]);
        $compiler->write(')');
        $compiler->compile($this->children[2]);
    }
}
