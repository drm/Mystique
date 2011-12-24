<?php
namespace MystiqueTest\PHP\Node;

use \Mystique\PHP\Node\MethodDeclaration;
use \Mystique\PHP\Node\DocBlock;
use PHPUnit_Framework_TestCase;

class DocBlockTest extends PHPUnit_Framework_TestCase {
    function setUp () {
        $this->compiler = new \Mystique\Common\Compiler\Compiler();
    }


    /**
     * @dataProvider cases
     */
    function testCases($expected, $docs) {
        $this->assertEquals($expected, $this->compiler->compile(new DocBlock($docs))->result);
    }


    function cases() {
        $ret = array();
        $ret[]= array(
"/**
 */",
            '',
        );

        $ret[]= array(
"/**
 */",
            "\n",
        );
        $ret[]= array(
"/**
 */",
            "\n\n",
        );
        $ret[]= array(
"/**
 * Line one
 * Line two
 */",
            "Line one\nLine two",
        );

        return $ret;
    }
}
