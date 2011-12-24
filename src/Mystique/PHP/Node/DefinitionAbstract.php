<?php
namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;

class DefinitionAbstract extends \Mystique\PHP\Node\BranchAbstract implements \Mystique\Compiler\Compilable {
    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
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