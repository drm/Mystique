<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class NestedVariable extends BranchAbstract {
    function getNodeType() {
        return 'nested-variable';
    }
}