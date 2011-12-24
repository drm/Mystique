<?php

namespace Meander\PHP\Node;

class SwitchNode extends BranchAbstract {
    function __construct($expr, $cases) {
        parent::__construct();
        $this->children->append($expr);
        foreach($cases as $case) {
            $this->children->append($case);
        }
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('switch')->write('(');
        $compiler->compile($this->children[0]);
        $compiler->write(')');
        $compiler->write('{');
        $compiler->compile($this->children[1]);
        $compiler->write('}');
    }

    function getNodeType() {
        return 'Switch';
    }
}