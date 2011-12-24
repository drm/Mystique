<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\Node;
use \Mystique\PHP\Node\Condition;
class ForNode extends BranchAbstract {
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

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('for')->write('(');
        $compiler->compile($this->children[0])->write(';');
        $compiler->compile($this->children[1])->write(';');
        $compiler->compile($this->children[2])->write(')');
        $compiler->compile($this->children[3]);
    }
}
