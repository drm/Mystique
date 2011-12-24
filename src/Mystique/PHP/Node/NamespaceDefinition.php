<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;

class NamespaceDefinition extends BranchAbstract {
    function getNodeType()
    {
        return 'Definition';
    }
}