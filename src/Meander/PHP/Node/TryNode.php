<?php
namespace Meander\PHP\Node;

class TryNode extends DefinitionAbstract {
    function getNodeType()
    {
        return 'Try';
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('try');
        parent::compile($compiler);
    }
}