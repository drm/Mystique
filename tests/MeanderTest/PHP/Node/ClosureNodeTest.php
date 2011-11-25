<?php

namespace MeanderTest\PHP\Node;

use \MeanderTest\TestCase;

class ClosureNodeTest extends TestCase {
    protected function setUp()
    {
        parent::setUp();
        $this->compiler = new \Meander\Compiler\Compiler();
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
            return new \Meander\PHP\Node\ClosureNode();
        };

        $ret[]=array('function (){}', $c());
        $ret[]=array('function ($a){}',
            $c()->addParameter(new \Meander\PHP\Node\ParameterDefinition('a'))
        );
        $ret[]=array(
            'function ($a, $b) {}',
             $c()
                 ->addParameter(new \Meander\PHP\Node\ParameterDefinition('a'))
                 ->addParameter(new \Meander\PHP\Node\ParameterDefinition('b'))
        );
        $ret[]=array(
            'function ($a, $b) use ($c, $d){}',
             $c()
                 ->addParameter(new \Meander\PHP\Node\ParameterDefinition('a'))
                 ->addParameter(new \Meander\PHP\Node\ParameterDefinition('b'))
                 ->addUse(new \Meander\PHP\Node\Variable('c'))
                 ->addUse(new \Meander\PHP\Node\Variable('d'))
        );
        return $ret;
    }
}