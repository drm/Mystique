<?php
namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;

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