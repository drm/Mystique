<?php

namespace Meander\PHP\Node;

class MethodNode extends FunctionNode {
    function __construct() {
        parent::__construct();
    }

    function setDeclaration()
    {
        $this->children[0] = new MethodDeclaration();
    }

    function getNodeType()
    {
        return 'Method';
    }
}