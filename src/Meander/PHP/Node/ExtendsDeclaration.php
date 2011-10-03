<?php
namespace Meander\PHP\Node;

class ExtendsDeclaration extends BranchAbstract {
    function __construct($name) {
        parent::__construct();
        $this->children->append($name);
    }

    function getNodeType() {
        return 'Extends';
    }

    function __toString() {
        return (string)$this->children[0];
    }
}