<?php
namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\NodeList;

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

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('catch')->write('(')->compile($this->children[0])->write(')')->compile($this->children[1]);
    }
}