<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;
use InvalidArgumentException;

class FunctionDefinition extends BranchAbstract implements Compilable {
    protected $name;
    protected $params       = null;

    private $abstract       = false;
    protected $body;

    function __construct($name = null) {
        $this->name = $name;
        $this->params = new ParameterDefinitionList();
    }


    function setName($name) {
        $this->name = $name;
    }


    function setRawBody($body) {
        $this->body = $body;
        return $this;
    }


    function addParameter(ParameterDefinition $param) {
        $this->params->add($param);
        return $this;
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
