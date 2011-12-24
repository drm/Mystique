<?php
namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;

class UseNode extends BranchAbstract {
    function __construct($name, $alias) {
        parent::__construct();
        $this->children[0] = $name;
        if($alias) {
            $this->children[1] = $alias;
        }
    }

    function getNodeType()
    {
        return 'use';
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->compile($this->children[0]);
        if(!empty($this->children[1])) {
            $compiler->write('as');
            $compiler->compile($this->children[1]);
        }
    }
}