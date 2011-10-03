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


    function compile(CompilerInterface $compiler) {
        $compiler->write('function');
        if($this->name) {
            $compiler->write(' ')->write($this->name);
        }
        $this->params->compile($compiler);

        if($this->abstract) {
            $compiler->write(';');
        } else {
            $compiler->write('{');
            $compiler->write($this->body);
            $compiler->write('}');
        }
    }
}
