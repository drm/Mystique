<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;
use InvalidArgumentException;

class FunctionDeclaration extends BranchAbstract implements Compilable {
    function __construct($name = null) {
        if($name) {
            $this->setName($name);
        }
    }


    function setName(Name $name) {
        $this->children[0] = $name;
    }



    function setParameters(ParameterDefinitionList $params) {
        $this->children[1] = $params;
    }


    function haveParams() {
        if(!isset($this->children[1])) {
            $this->children[1]= new ParameterDefinitionList();
        }
        return $this->children[1];
    }


    function compile(CompilerInterface $compiler) {
        $compiler->write('function');
        $compiler->write(' ')->write($this->children[0]->getNodeValue());
        $this->haveParams()->compile($compiler);
    }

    function getNodeType()
    {
        return 'Declaration';
    }
}
