<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class DefinitionAbstract extends \Meander\PHP\Node\BranchAbstract implements \Meander\Compiler\Compilable {
    function compile(\Meander\Compiler\CompilerInterface $compiler) {
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