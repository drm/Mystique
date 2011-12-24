<?php

namespace MystiqueTest\PHP\Node;

use \MystiqueTest\TestCase;

class ClosureNodeTest extends TestCase {
    protected function setUp()
    {
        parent::setUp();
        $this->compiler = new \Mystique\Common\Compiler\Compiler();
    }


    /**
     * @dataProvider cases
     * @return void
     */
    function testCompilation($expected, $method) {
        $this->assertSyntaxEquals($expected, $this->compiler->compile($method)->result);
    }


    function cases() {
        $ret = array();

        $c = function() {
            return new \Mystique\PHP\Node\ClosureNode();
        };

        $ret[]=array('function (){}', $c());
        $ret[]=array('function ($a){}',
            $c()->addParameter(new \Mystique\PHP\Node\ParameterDefinition('a'))
        );
        $ret[]=array(
            'function ($a, $b) {}',
             $c()
                 ->addParameter(new \Mystique\PHP\Node\ParameterDefinition('a'))
                 ->addParameter(new \Mystique\PHP\Node\ParameterDefinition('b'))
        );
        $ret[]=array(
            'function ($a, $b) use ($c, $d){}',
             $c()
                 ->addParameter(new \Mystique\PHP\Node\ParameterDefinition('a'))
                 ->addParameter(new \Mystique\PHP\Node\ParameterDefinition('b'))
                 ->addUse(new \Mystique\PHP\Node\Variable('c'))
                 ->addUse(new \Mystique\PHP\Node\Variable('d'))
        );
        return $ret;
    }
}