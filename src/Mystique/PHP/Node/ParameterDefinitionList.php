<?php
namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\Node;

class ParameterDefinitionList extends BranchAbstract implements Compilable {
    function compile(CompilerInterface $compiler) {
        $compiler->write('(');
        $first = true;
        foreach($this->children as $param) {
            /** @var $param ParameterDefinition */
            if(!$first) {
                $compiler->write(',')->write(' ');
            } else {
                $first = false;
            }
            $param->compile($compiler);
        }
        $compiler->write(')');
    }


    function add(Node $param) {
        if (! $param instanceof ParameterDefinition) {
            throw new \InvalidArgumentException("Expected ParameterDefinition");
        }
        $this->children[]= $param;
    }

    function getNodeType()
    {
        return 'Params';
    }
}