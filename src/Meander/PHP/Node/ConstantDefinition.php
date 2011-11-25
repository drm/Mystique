<?php

namespace Meander\PHP\Node;

class ConstantDefinition extends BranchAbstract {
    function setName($name) {
        $this->children[0] = $name;
    }


    function setValue($value) {
        $this->children[1] = $value;
    }
}