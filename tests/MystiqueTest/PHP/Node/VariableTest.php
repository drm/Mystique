<?php

namespace MystiqueTest\PHP\Node\VariableTest;

use PHPUnit_Framework_TestCase,
    \Mystique\PHP\Node\Variable;

class VariableTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider variables
     */
    function testCompile($expect, $name) {
        $compiler = new \Mystique\Common\Compiler\Compiler();
        $compiler->compile(new Variable($name));
        $this->assertEquals($expect, $compiler->result);
    }


    function variables() {
        return array(
            array('$a', 'a'),
            array('$A', 'A'),
            array('$_a', '_a'),
            array('$_A', '_A'),
            array('$a1', 'a1'),
            array('$A2', 'A2'),
            array('$_a1', '_a1'),
            array('$_A2', '_A2'),
            array('${\'1234\'}', '1234'),
        );
    }
}