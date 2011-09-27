<?php
namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class PropertyDefinition extends MemberDefinitionAbstract {
    protected $visibility = 'public';
    private $name;
    private $defaultValue;

    function __construct($name) {
        $this->name = $name;
    }


    function setDefaultValue(Compilable $defaultValue) {
        $this->defaultValue = $defaultValue;
    }


    function compile(CompilerInterface $compiler) {
        $this->compileDefinition($compiler);
        $compiler->write('$' . $this->name);
        if($this->defaultValue) {
            $compiler->write('=')->compile($this->defaultValue);
        }
        $compiler->write(';');
    }
}