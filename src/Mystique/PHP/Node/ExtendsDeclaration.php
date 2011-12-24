<?php
namespace Mystique\PHP\Node;

class ExtendsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Extends';
    }
}