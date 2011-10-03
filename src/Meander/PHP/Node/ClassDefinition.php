<?php

namespace Meander\PHP\Node;

class ClassDefinition extends \Meander\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'Definition';
    }
}