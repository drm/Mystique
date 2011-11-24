<?php
namespace Meander\PHP\Node;

class FunctionNode extends DefDeclNodeAbstract {
    function __construct($name = null)
    {
        parent::__construct();
        if($name) {
            $this->setName(new Name($name));
        }
    }


    function setByRef($byRef = true) {
        $this->setFlag('by-ref', $byRef);
    }

    function setDeclaration()
    {
        $this->children[0] = new FunctionDeclaration();
    }

    function setDefinition(NodeList $definition = null)
    {
        $this->children[1] = new FunctionDefinition($definition);
    }

    function getNodeType()
    {
        return 'Function';
    }
}