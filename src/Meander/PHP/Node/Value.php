<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable,
    \Meander\Compiler\CompilerInterface,
    InvalidArgumentException;

class Value extends LeafAbstract implements Compilable
{
    const T_STRING = 'string';
    const T_BOOL = 'boolean';
    const T_NULL = 'null';
    const T_INTEGER = 'integer';
    const T_FLOAT = 'float';

    protected $value;

    function __construct($value, $type)
    {
        if(!is_string($value) && !is_numeric($value) && !is_null($value) && $value !== false && $value !== true) {
            throw new InvalidArgumentException("Value is not a valid primitive");
        }
        if(!in_array($type, array(self::T_STRING, self::T_BOOL, self::T_NULL, self::T_INTEGER, self::T_FLOAT))) {
            throw new InvalidArgumentException("Invalid type {$type}");
        }
        $this->value = $value;
        $this->type = $type;
    }


    function getNodeType() {
        return $this->type;
    }


    function getNodeValue()
    {
        return (($this->value === false) ? 'false' : (($this->value === true) ? 'true' : ($this->value === null ? 'null' : $this->value)));
    }


    function compile(CompilerInterface $compiler)
    {
        if(is_string($this->value)) {
            $compiler->write($this->value);
        } elseif(is_numeric($this->value)) {
            $compiler->write((string) $this->value);
        } else {
            $compiler->write(strtolower(var_export($this->value, true)));
        }
    }
}