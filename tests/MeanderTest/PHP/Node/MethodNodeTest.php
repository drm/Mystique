<?php
namespace MeanderTest\PHP\Node;
use \Meander\PHP\Node\MethodDeclaration;
use PHPUnit_Framework_TestCase;

use \MeanderTest\PHP\Assert;

class MethodNodeTest extends PHPUnit_Framework_TestCase {
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
        $method = new \Meander\PHP\Node\MethodNode('a');
        $param1 = new \Meander\PHP\Node\ParameterDefinition('x');
        $param2 = new \Meander\PHP\Node\ParameterDefinition('y');
        $param3 = new \Meander\PHP\Node\ParameterDefinition('z');
        $param2->setDefaultValue(new \Meander\PHP\Node\Name('null'));
        $param3->setDefaultValue(new \Meander\PHP\Node\Name('null'))->setTypeHint('\Some\Namespace\Class');
        $method->addParameter($param1);
        $method->addParameter($param2);
        $method->addParameter($param3);

        $method->setAbstract();

        $this->assertEquals('abstract function a($x, $y = null, \Some\Namespace\Class $z = null);', $this->compiler->compile($method)->result);
    }


    function cases() {
        $ret = array();

        $m = function($name) {
            return new \Meander\PHP\Node\MethodNode($name);
        };

        $ret[]=array("function x(){}", $m('x'));
        $ret[]=array('final function x(){}', $m('x')->setFinal());
        // even though this does not make sense, the compiler doesn't care.
        $ret[]=array('abstract final function x();', $m('x')->setFinal()->setAbstract());
        $ret[]=array('abstract public static final function x();', $m('x')->setVisibility('public')->setStatic()->setFinal()->setAbstract());

        return $ret;
    }
}