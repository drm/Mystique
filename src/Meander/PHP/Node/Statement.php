<?php

namespace Meander\PHP\Node;

class Statement extends BranchAbstract {
    function __construct($e) {
        parent::__construct();
        if(!is_null($e)) {
            $this->children[0] = $e;
        }
    }
}