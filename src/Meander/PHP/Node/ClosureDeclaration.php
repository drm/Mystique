<?php
namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;

class ClosureDeclaration extends BranchAbstract implements \Meander\Compiler\Compilable {
    function setParameters(ParameterDefinitionList $params) {
        $this->children[0] = $params;
    }


    function setUse(UseList $use) {
        $this->children[1] = $use;
    }


    function haveParams() {
        if(!isset($this->children[0])) {
            $this->children[0]= new ParameterDefinitionList();
        }
        return $this->children[0];
    }


    function haveUse() {
        if(!isset($this->children[1])) {
            $this->children[1]= new UseList();
        }
        return $this->children[1];
    }


    function addParameter(ParameterDefinition $p) {
        $this->haveParams()->add($p);
        return $this;
    }

    function addUse(Variable $p) {
        $this->haveUse()->add($p);
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        $compiler->write('function');
        $this->haveParams()->compile($compiler);
        if(count($this->children[1])) {
            $compiler->write('use')->compile($this->haveUse());
        }
    }

    function getNodeType()
    {
        return 'Declaration';
    }
}