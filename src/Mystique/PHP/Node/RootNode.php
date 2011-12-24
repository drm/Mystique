<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable,
    \Mystique\Compiler\CompilerInterface;

class RootNode extends BranchAbstract implements Compilable {
    function add(Node $node) {
        $this->children->append($node);
    }

    

    function getNodeValue() {
        return null;
    }
}