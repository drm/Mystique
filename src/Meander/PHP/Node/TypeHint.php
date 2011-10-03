<?php
namespace Meander\PHP\Node;
        
class TypeHint extends BranchAbstract {
    function __construct($type) {
        parent::__construct();
        $this->setType($type);
    }
    
    function setType(Node $type) {
        $this->children[0] = $type;
    }
}