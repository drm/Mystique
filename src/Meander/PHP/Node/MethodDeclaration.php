<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;
use InvalidArgumentException;

class MethodDeclaration extends MemberDefinitionAbstract implements Compilable {
    private $abstract       = false;
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
        $this->abstract = (bool)$abstract;
        return $this;
    }

    
    function addParameter(ParameterDefinition $param) {
        $this->children[1]->add($param);
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        $this->abstract     && $compiler->write('abstract');
        $this->compileDefinition($compiler);
        
        $compiler->write('function')->write(' ');
        $compiler->write($this->name);
        $this->params->compile($compiler);

        if($this->abstract) {
            $compiler->write(';');
        } else {
            $compiler->write('{');
            if($this->body) {
                $compiler->compile($this->body);
            }
            $compiler->write('}');
        }
    }


    function setParameters(ParameterDefinitionList $params) {
        $this->children[1] = $params;
    }


    function getNodeType()
    {
        return 'Declaration';
    }
}
