<?php
namespace MeanderTest\PHP\Node;
use \Meander\PHP\Node\MethodDefinition;
use PHPUnit_Framework_TestCase;

use \MeanderTest\PHP\Assert;

class MethodDefinitionTest extends PHPUnit_Framework_TestCase {
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
        Assert::assertSyntaxEquals($expected, $this->compiler->compile($method)->result);
    }


    function testParameterList() {
        $method = new MethodDefinition('a');
        $param1 = new \Meander\PHP\Node\ParameterDefinition('x');
        $param2 = new \Meander\PHP\Node\ParameterDefinition('y');
        $param3 = new \Meander\PHP\Node\ParameterDefinition('z');
        $param2->setDefaultValue('null');
        $param3->setDefaultValue('null')->setTypeHint('\Some\Namespace\Class');
        $method->params->add($param1);
        $method->params->add($param2);
        $method->params->add($param3);

        $method->setAbstract();

        $this->assertEquals('abstract function a($x, $y = null, \Some\Namespace\Class $z = null);', $this->compiler->compile($method)->result);
    }


    function cases() {
        $ret = array();

        $m = function($name) {
            return new MethodDefinition($name);
        };

        $ret[]=array("function x(){}", $m('x'));
        $ret[]=array('final function x(){}', $m('x')->setFinal());
        // even though this does not make sense, the compiler doesn't care.
        $ret[]=array('abstract final function x();', $m('x')->setFinal()->setAbstract());
        $ret[]=array('abstract public static final function x();', $m('x')->setVisibility('public')->setStatic()->setFinal()->setAbstract());

        return $ret;
    }
}