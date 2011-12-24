<?php

namespace Mystique\PHP\Node;

use \Mystique\PHP\Node\Condition;
class WhileNode extends BranchAbstract {
    function __construct($condition, $statement) {
        parent::__construct();
        $this->children[0] = new Condition($condition);
        $this->children[1] = $statement;
    }

    
    function getNodeType()
    {
        return 'While';
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('while');
        parent::compile($compiler);
    }
}