<?php
namespace Mystique\PHP\Node;

class ConstantString extends \Mystique\PHP\Node\Value {
    function __construct($value, $quote) {
        parent::__construct($value, self::T_STRING);
        $this->quote = $quote;
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->quote);
        $compiler->write($this->value);
        $compiler->write($this->quote);
    }
}