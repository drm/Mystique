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

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('catch')->write('(')->compile($this->children[0])->write(')')->compile($this->children[1]);
    }
}