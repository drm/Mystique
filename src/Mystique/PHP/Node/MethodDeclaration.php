<?php
namespace Mystique\PHP\Node;

use \Mystique\Compiler\CompilerInterface;
use \Mystique\Compiler\Compilable;
use InvalidArgumentException;

class MethodDeclaration extends MemberDeclarationAbstract implements Compilable {
    protected $body;

    function __construct($name = null) {
        parent::__construct();
        if(!is_null($name)) {
            $this->setName(new Name($name));
        }
    }

    function setName(Name $name) {
        return $this->children[0] = $name;
    }
    

    function setAbstract($abstract = true) {
        $this->setFlag('abstract', $abstract);
        return $this;
    }

    
    function addParameter(ParameterDefinition $param) {
        $this->haveParams()->add($param);
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        $this->hasAttribute('abstract') && $compiler->write('abstract');
        $this->compileDefinition($compiler);
        $compiler->write('function')->write(' ');
        $compiler->write($this->children[0]->getNodeValue());
        $this->haveParams()->compile($compiler);
    }


    function haveParams() {
        if(!isset($this->children[1])) {
            $this->children[1] = new ParameterDefinitionList();
        }
        return $this->children[1];
    }


    function setParameters(ParameterDefinitionList $params) {
        $this->children[1] = $params;
    }


    function getNodeType()
    {
        return 'Declaration';
    }
}
