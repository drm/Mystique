<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\NodeList;

class ClosureNode extends DefDeclNodeAbstract {
    function setDeclaration()
    {
        $this->children[0] = new ClosureDeclaration();
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new ClosureDefinition($definition);
    }

    function getNodeType()
    {
        return 'Closure';
    }
}