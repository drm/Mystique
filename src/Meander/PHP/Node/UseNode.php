<?php
namespace Meander\PHP\Node;

class UseNode extends BranchAbstract {
    function __construct($name, $alias) {
        parent::__construct();
        $this->children[0] = $name;
        if($alias) {
            $this->children[1] = $alias;
        }
    }

    function getNodeType()
    {
        return 'use';
    }
}