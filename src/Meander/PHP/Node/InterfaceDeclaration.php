<?php
namespace Meander\PHP\Node;

class InterfaceDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Declaration';
    }


    function setName($name) {
        $this->children[0] = $name;
    }

    function getName() {
        return $this->children[0];
    }


    function setExtends($name) {
        $this->children[1]= new ExtendsDeclaration($name);
    }

    function getExtends() {
        return $this->children[1];
    }
}