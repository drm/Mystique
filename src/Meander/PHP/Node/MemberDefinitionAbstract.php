<?php
namespace Meander\PHP\Node;
use \Meander\Compiler\Compilable;
use \Meander\Compiler\Compiler;
use InvalidArgumentException;

abstract class MemberDefinitionAbstract implements Compilable {
    const IS_PRIVATE    = 'private';
    const IS_PUBLIC     = 'public';
    const IS_PROTECTED  = 'protected';

    private     $final          = false;
    protected   $visibility     = '';
    private     $static         = false;


    /**
     * @param $final bool
     */
    function setFinal($final = true) {
        $this->final = (bool)$final;
        return $this;
    }

    /**
     * @param $static bool
     */
    function setStatic($static = true) {
        $this->static = (bool)$static;
        return $this;
    }



    function __get($name) {
        if(in_array($name, array('static', 'final', 'abstract', 'visibility', 'params'))) {
            return $this->$name;
        }
        throw new InvalidArgumentException('Undefined property');
    }


    /**
     * @param $visibility bool
     */
    function setVisibility($visibility) {
        static $visibilities = array(self::IS_PRIVATE, self::IS_PUBLIC, self::IS_PROTECTED);
        if(!in_array($visibility, $visibilities)) {
            throw new InvalidArgumentException("Expected one of " . implode(', ', $visibilities));
        }
        $this->visibility = $visibility;
        return $this;
    }


    final protected function compileDefinition(Compiler $compiler) {
        $this->visibility   && $compiler->write($this->visibility)->write(' ');
        $this->static       && $compiler->write('static')->write(' ');
        $this->final        && $compiler->write('final')->write(' ');
    }
}