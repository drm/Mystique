<?php
namespace Mystique\PHP\Node;

class NamespaceDefinition extends BranchAbstract {
    function getNodeType()
    {
        return 'Definition';
    }
}