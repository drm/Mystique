<?php
namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;

use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;

class DefinitionAbstract extends BranchAbstract implements \Mystique\Common\Compiler\Compilable {
    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->write('{');
        foreach($this->getNodeChildren() as $member) {
            $compiler->compile($member);
        }
        $compiler->write('}');
    }


    function getNodeType() {
        return 'Definition';
    }
}