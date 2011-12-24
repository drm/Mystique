<?php

namespace Meander\PHP\Node;


class CaseDefaultNode extends \Meander\PHP\Node\BranchAbstract {
    function __construct($body) {
        $this->children[0] = $body;
    }

    function getNodeType() {
        return 'Default';
    }
}