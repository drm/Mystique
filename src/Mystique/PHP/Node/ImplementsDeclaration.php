<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;

class ImplementsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Implements';
    }
}