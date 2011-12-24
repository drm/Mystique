<?php

namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\Compilable,
    \Mystique\Common\Compiler\CompilerInterface;

use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\Node;

class RootNode extends BranchAbstract implements Compilable {
    function add(Node $node) {
        $this->children->append($node);
    }

    

    function getNodeValue() {
        return null;
    }
}