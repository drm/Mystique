<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\CompilerInterface;
use \Mystique\Compiler\Compilable;
use \Mystique\PHP\Token\Token;

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