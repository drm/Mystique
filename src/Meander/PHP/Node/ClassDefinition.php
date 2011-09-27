<?php

namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ClassDefinition extends BranchAbstract implements Compilable {
    private $final = false;
    private $name = null;
    private $extends = null;
    private $implements = array();
    private $members = array();
    private $abstract = false;
    private $doc = null;
    private $rawBody = '';
    protected $type = 'class';

    
    function __construct($name = null) {
        if (!is_null($name)) {
            $this->setName($name);
        }
    }


    function setDoc($doc) {
        $this->doc = $doc;
    }


    function getDoc() {
        return $this->doc;
    }


    function setName($name) {
        $this->name = $name;
    }


    function isFinal () {
        return $this->final;
    }


    function isAbstract() {
        return $this->abstract;
    }


    function getExtends() {
        return $this->extends;
    }


    function getImplements() {
        return $this->implements;
    }


    function getName() {
        return $this->name;
    }


    function setExtends($extends) {
        if(is_string($extends)) {
            $extends = new Name($extends);
        }
        $this->extends = $extends;
    }


    function addImplements($interface) {
        if(is_array($interface)) {
            foreach($interface as $i) {
                $this->addImplements($i);
            }
        } else {
            if(is_string($interface)) {
                $interface = new Name($interface);
            }
            $this->implements[]= $interface;
        }
    }


    function compile(CompilerInterface $compiler) {
        $this->final && $compiler->write('final');
        $this->abstract && $compiler->write('abstract');
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
        $this->abstract = (bool)$abstract;
    }

    public function setFinal($final = true)
    {
        $this->final = (bool)$final;
    }

    function setRawBody($body) {
        $this->rawBody = $body;
    }

    function getRawBody() {
        return $this->rawBody;
    }
}