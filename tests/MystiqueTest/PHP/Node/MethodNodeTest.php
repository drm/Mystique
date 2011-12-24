<?php
namespace MystiqueTest\PHP\Node;
use \Mystique\PHP\Node\MethodDeclaration;
use PHPUnit_Framework_TestCase;

use \MystiqueTest\PHP\Assert;

class MethodNodeTest extends PHPUnit_Framework_TestCase {
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
        Assert::assertSyntaxEquals($expected, $this->compiler->compile($method)->result);
    }


    function testParameterList() {
        $method = new \Mystique\PHP\Node\MethodNode('a');
        $param1 = new \Mystique\PHP\Node\ParameterDefinition('x');
        $param2 = new \Mystique\PHP\Node\ParameterDefinition('y');
        $param3 = new \Mystique\PHP\Node\ParameterDefinition('z');
        $param2->setDefaultValue(new \Mystique\PHP\Node\Name('null'));
        $param3->setDefaultValue(new \Mystique\PHP\Node\Name('null'))->setTypeHint('\Some\Namespace\Class');
        $method->addParameter($param1);
        $method->addParameter($param2);
        $method->addParameter($param3);

        $method->setAbstract();

        $this->assertEquals('abstract function a($x, $y = null, \Some\Namespace\Class $z = null);', $this->compiler->compile($method)->result);
    }


    function cases() {
        $ret = array();

        $m = function($name) {
            return new \Mystique\PHP\Node\MethodNode($name);
        };

        $ret[]=array("function x(){}", $m('x'));
        $ret[]=array('final function x(){}', $m('x')->setFinal());
        // even though this does not make sense, the compiler doesn't care.
        $ret[]=array('abstract final function x();', $m('x')->setFinal()->setAbstract());
        $ret[]=array('abstract public static final function x();', $m('x')->setVisibility('public')->setStatic()->setFinal()->setAbstract());

        return $ret;
    }
}