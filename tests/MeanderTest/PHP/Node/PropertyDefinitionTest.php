<?php
namespace MeanderTest\PHP\Node;
use \Meander\PHP\Node\MethodDefinition;
use PHPUnit_Framework_TestCase;

class PropertyDefinitionTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        $this->compiler = new \Meander\Compiler\Compiler();
    }

    /**
     * @dataProvider cases
     * @return void
     */
    function testCompilation($expected, $method) {
        $this->assertEquals($expected, $this->compiler->compile($method)->result);
    }



    function cases() {
        $p = function($n) {
            return new \Meander\PHP\Node\PropertyDefinition($n);
        };

        $ret = array();
        $ret[]= array('public $v;', $p('v')->setVisibility(\Meander\PHP\Node\MemberDefinitionAbstract::IS_PUBLIC));
        return $ret;
    }


}