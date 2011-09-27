<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable,
    \Meander\Compiler\CompilerInterface,
    InvalidArgumentException;

class Value extends LeafAbstract implements Compilable
{
    protected $value;

    function __construct($value)
    {
        if(!is_string($value) && !is_numeric($value) && !is_null($value) && $value !== false && $value !== true) {
            throw new InvalidArgumentException("Value is not a valid primitive");
        }
        $this->value = $value;
    }


    function getNodeType() {
        return gettype($this->value);
    }


    function getNodeValue()
    {
        return (($this->value === false) ? 'false' : (($this->value === true) ? 'true' : ($this->value === null ? 'null' : $this->value)));
    }


    function compile(CompilerInterface $compiler)
    {
        $compiler->write(var_export($this->value, true));
    }
}