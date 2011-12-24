<?php

namespace MystiqueTest\PHP\Node;

use PHPUnit_Framework_TestCase;
use \Mystique\PHP\Node\Value;

class ValueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validValues
     */
    function testConstruction($validValue, $type)
    {
        $value = new Value($validValue, $type);
//        $this->assertEquals($validValue, $value->getNodeValue());
    }


    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidValues
     */
    function testInvalidValueThrowsException($invalidValue, $type)
    {
        $value = new Value($invalidValue, $type);
    }


    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidTypes
     */
    function testInvalidTypeThrowsException($validValue, $type)
    {
        $value = new Value($validValue, $type);
    }


    /**
     * @dataProvider exportableValues
     * @param $expect
     * @param $value
     * @return void
     */
    function testExportableValuesCompile($expect, $value, $type)
    {
        $compiler = new \Mystique\Compiler\Compiler();
        $compiler->compile(new Value($value, $type));
        $this->assertEquals($expect, $compiler->result);
    }


    function exportableValues()
    {
        return
            array(
                array('true', true, Value::T_BOOL),
                array('false', false, Value::T_BOOL),
                array('null', null, Value::T_NULL),
                array("''", '\'\'', Value::T_STRING),
                array("'a'", '\'a\'', Value::T_STRING),
                array("\"a\"", '"a"', Value::T_STRING),
                array("\"\"", '""', Value::T_STRING),
                array('0', '0', Value::T_INTEGER),
                array('0.1', '0.1', Value::T_FLOAT),
                array('0x00', '0x00', VAlue::T_INTEGER),
                array('-1', '-1', Value::T_INTEGER)
            )
        ;
    }




    function invalidValues () {
        return array(
            array(new \stdClass, Value::T_STRING),
            array(array(), Value::T_STRING),
        );
    }

    function invalidTypes() {
        return array(
            array(true, '?'),
        );
    }


    function validValues() {
        return
            array(
                array(true, Value::T_BOOL),
                array(false, Value::T_BOOL),
                array(null, Value::T_NULL),
                array("", Value::T_STRING),
                array("a", Value::T_STRING)
            )
        ;
    }
}