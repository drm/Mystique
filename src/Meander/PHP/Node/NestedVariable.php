<?php

namespace Meander\PHP\Node;

class NestedVariable extends \Meander\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'nested-variable';
    }
}