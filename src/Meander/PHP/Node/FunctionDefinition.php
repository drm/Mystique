<?php

namespace Meander\PHP\Node;

class FunctionDefinition extends \Meander\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'Definition';
    }
}