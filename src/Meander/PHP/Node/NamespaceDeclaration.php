<?php
namespace Meander\PHP\Node;

class NamespaceDeclaration extends Statement {
    function setNamespace($namespace) {
        $this->children[0] = $namespace;
    }


    function getNodeType() {
        return 'Declaration';
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('namespace');
        parent::compile($compiler);
    }


}