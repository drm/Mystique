<?php

namespace Meander\PHP\Node;

class SwitchNode extends BranchAbstract {
    function __construct($expr, $body) {
        parent::__construct();
        $this->children->append($expr);
        $this->children->append($body);
    }
}