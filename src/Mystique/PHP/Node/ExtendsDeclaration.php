<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class ExtendsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Extends';
    }
}