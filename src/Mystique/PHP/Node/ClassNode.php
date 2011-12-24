<?php

namespace Mystique\PHP\Node;
use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;

use Mystique\Common\Ast\Node\NodeList;

class ClassNode extends InterfaceNode {
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