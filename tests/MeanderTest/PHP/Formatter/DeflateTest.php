<?php

namespace MeanderTest\PHP\Formatter;

class DeflateTest {
    /**
     * @dataProvider data
     */
    function testDeflate($stripComments, $in, $expect) {
        $deflater = new \Meander\PHP\Formatter\Deflate($stripComments);
        $this->assertEquals('<?php ' . $expect, $deflater->format('<?php ' . $in));
    }


    function data() {
        $ret = array();
        $ret[]= array(true, 'function a () { /* comment */ }', 'function a(){}');
        $ret[]= array(true, 'function a ( $param1 = "w00t", SomeClass $param2 = null ) { /* comment */ }', 'function a($param1="w00t",SomeClass$param2=null){}');
        $ret[]= array(true, 'function a () { /* comment */ }', 'function a(){/* comment */}');
        $ret[]= array(false, 'function a ( $param1 = "w00t", SomeClass $param2 = null ) { /* comment */ }', 'function a($param1="w00t",SomeClass$param2=null){/* comment */}');
        $ret[]= array(false, 'function ( ) { }',   'function(){}');
        $ret[]= array(false, 'function(){}',       'function(){}');
        $ret[]= array(false, 'function () { }',    'function(){}');
        $ret[]= array(false, 'function a () { }',    'function a(){}');
        $ret[]= array(false, 'function a () { }',    'function a(){}');
        return $ret;
    }
}