<?php
namespace Meander\PHP\Node;

class ConstantString extends \Meander\PHP\Node\Value {
    function __construct($value, $quote) {
        parent::__construct($value);
        $this->quote = $quote;
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->quote);
        $compiler->write($this->value);
        $compiler->write($this->quote);
    }
}