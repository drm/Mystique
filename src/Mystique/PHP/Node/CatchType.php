<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

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