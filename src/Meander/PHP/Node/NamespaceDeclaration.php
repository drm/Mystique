<?php
namespace Meander\PHP\Node;

class NamespaceDeclaration extends Statement {
    function setNamespace($namespace) {
        $this->children[0] = $namespace;
    }


    function getNodeType() {
        return 'Declaration';
    }
}