<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable,
    \Meander\Compiler\CompilerInterface;

class RootNode extends BranchAbstract implements Compilable {
    function add(Node $node) {
        $this->children->append($node);
    }

    

    function getNodeValue() {
        return null;
    }
}