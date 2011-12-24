<?php

namespace Meander\PHP\Node;

class CaseNode extends \Meander\PHP\Node\BranchAbstract {
    function __construct($expr, $body) {
        parent::__construct();
        $this->children[0] = $expr;
        $this->children[1] = $body;
    }


    function getNodeType() {
        return 'Case';
    }
}