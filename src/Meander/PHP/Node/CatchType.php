<?php

namespace Meander\PHP\Node;

class CatchType extends BranchAbstract {
    function setType($type) {
        $this->children[0]= $type;
    }

    function setVariable($name) {
        $this->children[1] = $name;
    }

    function getNodeType() {
        return 'Type';
    }
}