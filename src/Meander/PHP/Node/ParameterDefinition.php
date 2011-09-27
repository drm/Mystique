<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ParameterDefinition implements Compilable {
    private $typeHint;
    private $defaultValue;

    function __construct($name) {
        $this->name = $name;
    }


    function setTypeHint($type) {
        $this->typeHint = $type;
        return $this;
    }


    function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
        return $this;
    }


    function compile(CompilerInterface $compiler) {
        $this->typeHint     && $compiler->write($this->typeHint)->write(' ');
        $compiler->write('$' . $this->name);
        $this->defaultValue && $compiler->write(' ')->write('=')->write(' ')->write($this->defaultValue);
    }
}