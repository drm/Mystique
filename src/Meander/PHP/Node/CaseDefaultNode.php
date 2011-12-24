<?php

namespace Meander\PHP\Node;

use Meander\Compiler\CompilerInterface;

class CaseDefaultNode extends \Meander\PHP\Node\BranchAbstract {
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