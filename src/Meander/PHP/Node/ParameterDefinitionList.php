<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class ParameterDefinitionList implements Compilable {
    function __construct() {
        $this->params = array();
    }

    function compile(CompilerInterface $compiler) {
        $compiler->write('(');
        $first = true;
        foreach($this->params as $param) {
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


    function add(ParameterDefinition $param) {
        $this->params[]= $param;
    }
}