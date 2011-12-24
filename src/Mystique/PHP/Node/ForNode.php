<?php

namespace Mystique\PHP\Node;

use \Mystique\PHP\Node\Condition;
class ForNode extends \Mystique\PHP\Node\BranchAbstract {
    function __construct($expr, Node $statement) {
        parent::__construct();
        foreach($expr as $e) {
            $this->children->append($e ?: new Noop());
        }
        $this->children->append($statement);
    }

    function getNodeType()
    {
        return 'For';
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('for')->write('(');
        $compiler->compile($this->children[0])->write(';');
        $compiler->compile($this->children[1])->write(';');
        $compiler->compile($this->children[2])->write(')');
        $compiler->compile($this->children[3]);
    }
}
