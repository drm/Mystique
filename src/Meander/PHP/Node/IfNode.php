<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
class IfNode extends BranchAbstract {
    function __construct($condition, $statement) {
        parent::__construct();
        $this->children[0] = new Condition($condition);
        $this->children[1] = $statement;
    }



    function addElseIf($condition, $statement) {
        
    }


    function getNodeType()
    {
        return 'If';
    }
}