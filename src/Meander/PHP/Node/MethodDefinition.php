<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;
use InvalidArgumentException;

class MethodDefinition extends MemberDefinitionAbstract implements Compilable {
    protected $name;
    protected $params       = null;

    private $abstract       = false;
    protected $body;

    function __construct($name) {
        $this->name = $name;
        $this->params = new ParameterDefinitionList();
    }

    function setAbstract($abstract = true) {
        $this->abstract = (bool)$abstract;
        return $this;
    }


    function setBody(Compilable $body) {
        $this->body = $body;
        return $this;
    }


    function addParameter(ParameterDefinition $param) {
        $this->params->add($param);
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        $this->abstract     && $compiler->write('abstract')->write(' ');
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
}
