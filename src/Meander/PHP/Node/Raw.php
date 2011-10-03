<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;
use \Meander\PHP\Token\Token;

class Raw extends LeafAbstract implements Compilable {
    function __construct($code = '') {
        $this->code = $code;
    }


    function append(Token $token) {
        $this->code .= $token->value;
    }


    function compile(CompilerInterface $compiler) {
        $compiler->write($this->code);
    }


    function getNodeValue() {
        return $this->code;
    }
}