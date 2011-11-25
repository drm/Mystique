<?php
namespace Meander\PHP\Node;

class NamespaceDefinition extends BranchAbstract {
    function getNodeType()
    {
        return 'Definition';
    }
}