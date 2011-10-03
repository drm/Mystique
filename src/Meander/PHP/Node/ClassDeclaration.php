<?php
namespace Meander\PHP\Node;

class ClassDeclaration extends InterfaceDeclaration {
    function isFinal() {
        return (bool)$this->getAttribute('final');
    }


    function isAbstract() {
        return $this->hasAttribute('abstract');
    }


    function setFinal($final = true) {
        $this->setFlag('final', $final);
    }

    function setAbstract($abstract= true) {
        $this->setFlag('abstract', $abstract);
    }

    function getImplements() {
        if(isset($this->children[2])) {
            return $this->children[2];
        }
        return null;
    }

    function addImplements($name) {
        if(!isset($this->children[2])) {
            $this->children[2]= new ImplementsDeclaration();
        }
        $this->children[2]->add($name);
    }
}