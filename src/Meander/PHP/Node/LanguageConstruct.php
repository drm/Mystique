<?php

namespace Meander\PHP\Node;

class LanguageConstruct extends Statement {
    function __construct($type, $expression) {
        parent::__construct($expression);
        $this->type = $type;
    }

    function getNodeType() {
        return $this->type;
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->type);
        parent::compile($compiler);
    }
}