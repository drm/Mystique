<?php
namespace Meander\PHP\Node;

class FunctionNode extends DefDeclNodeAbstract {
    function setByRef($byRef) {
        $this->setFlag('by-ref', true);
    }

    function setDeclaration()
    {
        $this->children[0] = new FunctionDeclaration();
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new FunctionDefinition($definition);
    }

    function getNodeType()
    {
        return 'Function';
    }
}