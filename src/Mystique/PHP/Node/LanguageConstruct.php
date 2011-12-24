<?php

namespace Mystique\PHP\Node;

class LanguageConstruct extends Statement {
    function __construct($type, $expression) {
        parent::__construct($expression);
        $this->type = $type;
    }

    function getNodeType() {
        return $this->type;
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->type);
        parent::compile($compiler);
    }
}