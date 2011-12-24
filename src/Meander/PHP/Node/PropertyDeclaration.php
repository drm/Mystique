<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class PropertyDeclaration extends MemberDeclarationAbstract
{
    function getNodeType()
    {
        return 'Declaration';
    }

    function compile(CompilerInterface $compiler)
    {
        if(!$this->hasAttribute('visibility') && !$this->hasAttribute('static')) {
            $this->setVisibility(self::IS_PUBLIC);
        }
        $this->compileDefinition($compiler);
    }
}