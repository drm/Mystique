<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
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
}