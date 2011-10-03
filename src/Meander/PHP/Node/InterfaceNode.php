<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;


class InterfaceNode extends BranchAbstract {
    protected $doc = null;

    function __construct() {
        parent::__construct();
        $this->children[0] = new InterfaceDeclaration();
    }


    function setDoc($doc) {
        $this->doc = new DocBlock($doc);
    }


    function getDoc() {
        return $this->doc;
    }


    function setName(Name $name) {
        $this->children[0]->setName($name);
    }

    function getExtends() {
        return $this->children[0]->getExtends();
    }


    function getName() {
        return $this->children[0]->getName();
    }


    function setExtends($extends) {
        $this->children[0]->setExtends($extends);
    }


    function getNodeType()
    {
        return 'Interface';
    }


    function setDefinition(NodeList $definition) {
        $this->children[1] = new InterfaceDefinition($definition);
    }
}