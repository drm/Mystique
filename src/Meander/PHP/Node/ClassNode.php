<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ClassNode extends InterfaceNode implements Compilable {

    function __construct() {
        parent::__construct();
        $this->children[0] = new ClassDeclaration();
        $this->children[1] = new ClassDefinition();
    }


    function isFinal () {
        return $this->children[0]->isFinal();
    }


    function isAbstract() {
        return $this->children[0]->isAbstract();
    }

    function getImplements() {
        return $this->children[0]->getImplements();
    }

    function addImplements($interface) {
        $this->children[0]->addImplements($interface);
    }


    function compile(CompilerInterface $compiler) {
        $this->isFinal() && $compiler->write('final');
        $this->isAbstract() && $compiler->write('abstract');
        $compiler
                ->write($this->type)
                ->write($this->name)
        ;
        if($this->extends) {
            $compiler->write('extends')->compile($this->extends);
        }
        if($this->type == 'class' && $this->implements) {
            $compiler->write('implements');
            $first = true;
            foreach($this->implements as $impl) {
                !$first and $compiler->write(',') or $first = false;
                $compiler->compile($impl);
            }
        }
        $compiler->write('{');
        foreach($this->members as $property) {
            $compiler->compile($property);
        }
        $compiler->write('}');
    }


    function addMember(MemberDefinitionAbstract $method) {
        $this->members[]= $method;
    }

    public function setAbstract($abstract = true)
    {
        $this->children[0]->setAbstract($abstract);
    }

    public function setFinal($final = true)
    {
        $this->children[0]->setFinal($final);
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new ClassDefinition($definition);
    }


    function getNodeType() {
        return 'Class';
    }
}