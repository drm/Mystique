<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ParameterDefinition extends BranchAbstract implements Compilable {
    private $typeHint;
    private $defaultValue;

    
    function setName(Variable $name) {
        $this->children[1] = $name;
    }


    function setByRef($byRef = true) {
        $this->setFlag('by-ref', (bool)$byRef);
    }


    function setTypeHint($type) {
        $this->children[0] = new TypeHint($type);
    }


    function setDefaultValue(Node $defaultValue) {
        $this->children[]= $defaultValue;
    }


    function compile(CompilerInterface $compiler) {
        $this->typeHint     && $compiler->write($this->typeHint)->write(' ');
        $compiler->write('$' . $this->name);
        $this->defaultValue && $compiler->write(' ')->write('=')->write(' ')->write($this->defaultValue);
    }

    function getNodeType()
    {
        return 'Param';
    }
}