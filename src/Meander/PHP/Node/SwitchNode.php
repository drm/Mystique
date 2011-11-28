<?php

namespace Meander\PHP\Node;

class SwitchNode extends BranchAbstract {
    function __construct($expr, $body) {
        parent::__construct();
        $this->children->append($expr);
        $this->children->append($body);
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('switch')->write('(');
        $compiler->compile($this->children[0]);
        $compiler->write(')');
        $compiler->compile($this->children[1]);
    }
}