<?php

namespace Meander\PHP\Node;

class ClosureNode extends DefDeclNodeAbstract {
    function setDeclaration()
    {
        $this->children[0] = new ClosureDeclaration();
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new ClosureDefinition();
    }

    function getNodeType()
    {
        return 'Closure';
    }
}