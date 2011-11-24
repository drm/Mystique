<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ClassNode extends InterfaceNode implements Compilable {
    function __construct($name = null) {
        parent::__construct();
        if(!is_null($name)) {
            $this->setName($name);
        }
        $this->setDefinition(new NodeList());
    }


    function setDeclaration()
    {
        $this->children[0] = new ClassDeclaration();
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new ClassDefinition($definition);
    }


    function addMember($member) {
        return $this->children[1]->addMember($member);
    }


    function getNodeType() {
        return 'Class';
    }
}