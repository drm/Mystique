<?php

namespace Mystique\PHP\Node;

use \Mystique\PHP\Node\Condition;
use Mystique\Common\Ast\Node\BranchAbstract;

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

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('while');
        parent::compile($compiler);
    }
}