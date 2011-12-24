<?php

namespace Mystique\PHP\Node;

use Mystique\Compiler\CompilerInterface;

class CaseDefaultNode extends \Mystique\PHP\Node\BranchAbstract {
    function __construct($body) {
        parent::__construct();
        $this->children[0] = $body;
    }

    function getNodeType() {
        return 'Default';
    }

    function compile(CompilerInterface $compiler)
    {
        $compiler->write('default')->write(':')->compile($this->children[0]);
    }
}