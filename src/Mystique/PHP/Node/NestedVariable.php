<?php

namespace Mystique\PHP\Node;

class NestedVariable extends \Mystique\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'nested-variable';
    }
}