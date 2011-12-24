<?php

namespace Mystique\PHP\Node;

use Mystique\Compiler\CompilerInterface;

class CaseNode extends \Mystique\PHP\Node\BranchAbstract {
    function __construct($expr, $body) {
        parent::__construct();
        $this->children[0] = $expr;
        $this->children[1] = $body;
    }


    function getNodeType() {
        return 'Case';
    }

    function compile(CompilerInterface $compiler) {
        $compiler->write('case')->compile($this->children[0])->write(':')->compile($this->children[1]);
    }
}