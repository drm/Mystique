<?php
namespace Mystique\PHP\Node;

class NamespaceDeclaration extends Statement {
    function setNamespace($namespace) {
        $this->children[0] = $namespace;
    }


    function getNodeType() {
        return 'Declaration';
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('namespace');
        parent::compile($compiler);
    }


}