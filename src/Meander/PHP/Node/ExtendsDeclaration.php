<?php
namespace Meander\PHP\Node;

class ExtendsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Extends';
    }
}