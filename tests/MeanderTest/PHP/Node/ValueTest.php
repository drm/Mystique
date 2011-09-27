<?php

namespace MeanderTest\PHP\Node;

use PHPUnit_Framework_TestCase;
use \Meander\PHP\Node\Value;

class ValueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validValues
     */
    function testConstruction($validValue)
    {
        $value = new Value($validValue);
//        $this->assertEquals($validValue, $value->getNodeValue());
    }


    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidValues
     */
    function testInvalidValueThrowsException($invalidValue)
    {
        $value = new Value($invalidValue);
    }


    /**
     * @dataProvider exportableValues
     * @param $expect
     * @param $value
     * @return void
     */
    function testExportableValuesCompile($expect, $value)
    {
        $compiler = new \Meander\Compiler\Compiler();
        $compiler->compile(new Value($value));
        $this->assertEquals($expect, $compiler->result);
    }


    function exportableValues()
    {
        return
            array(
                array('true', true),
                array('false', false),
                array('NULL', null),
                array("''", ''),
                array("'a'", 'a'),
                array('0', 0),
                array('0.1', 0.1),
                array('0', 0x00),
                array('-1', -1)
            )
        ;
    }




    function invalidValues () {
        return array_map(
            function($a) { return array($a); },
            array(
                new \stdClass,
                array()
            )
        );
    }


    function validValues() {
        return array_map(
            function($a) { return array($a); },
            array(
                true,
                false,
                null,
                "",
                "a",
                0,
                0.1,
                0x00,
                0777,
                -1
            )
        );
    }
}