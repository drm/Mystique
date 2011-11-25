<?php
namespace Meander\PHP\Node;

class CatchNode extends DefDeclNodeAbstract {
    function setDeclaration() {
        $this->children[0] = new CatchType();
    }

    function setDefinition(NodeList $definition) {
        $this->children[1] = new CatchBody($definition);
    }

    function getNodeType()
    {
        return 'Catch';
    }
}