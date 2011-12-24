<?php
namespace Mystique\PHP\Node;
use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;

class PropertyDefinition extends MemberDeclarationAbstract {
    protected $visibility = 'public';


    function setName($name) {
        $this->children[0] = $name;
    }


    function setDefaultValue(Compilable $defaultValue) {
        $this->children[1] = $defaultValue;
    }


    function compile(CompilerInterface $compiler) {
        $compiler->compile($this->children[0]);
        if(isset($this->children[1])) {
            $compiler->write('=')->compile($this->children[1]);
        }
    }

    function getNodeType()
    {
        return 'Definition';
    }
}