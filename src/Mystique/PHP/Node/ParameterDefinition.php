<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;

class ParameterDefinition extends BranchAbstract implements Compilable {
    private $typeHint;
    private $defaultValue;

    function __construct($name = null) {
        parent::__construct();
        if($name) {
            $this->setName(new Variable($name));
        }
    }


    function setName(Variable $name) {
        $this->children[1] = $name;
    }


    function setByRef($byRef = true) {
        $this->setFlag('by-ref', (bool)$byRef);
        return $this;
    }


    function setTypeHint($type) {
        if(is_string($type)) {
            $this->children[0] = new TypeHint(new Name($type));
        } elseif($type instanceof TypeHint) {
            $this->children[0] = $type;
        } else {
            $this->children[0] = new TypeHint($type);
        }
        return $this;
    }


    function setDefaultValue(Node $defaultValue) {
        $this->children[2]= $defaultValue;
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        !empty($this->children[0]) && $compiler->compile($this->children[0])->write(' ');
        $compiler->compile($this->children[1]);
        !empty($this->children[2]) && $compiler->write(' ')->write('=')->write(' ')->compile($this->children[2]);
    }


    function getNodeType()
    {
        return 'Param';
    }
}