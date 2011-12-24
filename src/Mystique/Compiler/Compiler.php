<?php

namespace Mystique\Compiler;

use InvalidArgumentException;

class Compiler implements CompilerInterface
{
    public $result = '';

    function write($str)
    {
        if(!is_string($str)) {
            throw new InvalidArgumentException(
                'Can only write string values through write(). '
                . 'Either cast or implement Compilable and pass to compile()'
            );
        }
        if (strlen($str) == 0) {
            return $this;
        }
        if($this->_collides($str)) {
            $this->result .= ' ';
        }
        $this->result .= $str;
        return $this;
    }


    function compile(Compilable $node)
    {
        $node->compile($this);
        return $this;
    }


    private function _collides($str) {
        // this checks to see if there are word collisions if the next section is added to the code.
        // if so, a space is inserted.
        // Example: $compiler->write('function')->write('foo') would render 'function foo' and not 'functionfoo'.
        return preg_match('/\w/', $str{0}) && preg_match('/\w/', substr($this->result, -1));
    }
}