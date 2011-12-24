<?php
namespace Mystique\PHP\Node;
use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\Compiler;
use InvalidArgumentException;

abstract class MemberDeclarationAbstract extends BranchAbstract implements Compilable {
    const IS_PRIVATE    = 'private';
    const IS_PUBLIC     = 'public';
    const IS_PROTECTED  = 'protected';

    /**
     * @param $final bool
     */
    function setFinal($final = true) {
        $this->setFlag('final', $final);
        return $this;
    }

    /**
     * @param $static bool
     */
    function setStatic($static = true) {
        $this->setFlag('static', $static);
        return $this;
    }



    function __get($name) {
        if(in_array($name, array('static', 'final', 'abstract', 'visibility', 'params'))) {
            return $this->$name;
        }
        throw new InvalidArgumentException('Undefined property ' . $name);
    }


    /**
     * @param $visibility bool
     */
    function setVisibility($visibility) {
        static $visibilities = array(self::IS_PRIVATE, self::IS_PUBLIC, self::IS_PROTECTED);
        if(!in_array($visibility, $visibilities)) {
            throw new InvalidArgumentException("Expected one of " . implode(', ', $visibilities));
        }
        $this->setAttribute('visibility', $visibility);
        return $this;
    }


    protected function compileDefinition(Compiler $compiler) {
        $this->hasAttribute('visibility') && $compiler->write($this->getAttribute('visibility'));
        $this->hasAttribute('static') && $compiler->write('static');
        $this->hasAttribute('final') && $compiler->write('final');
    }
}