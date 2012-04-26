<?php

namespace MystiqueTest\Common\Ast;

use PHPUnit_Framework_TestCase;

class IteratorTest extends PHPUnit_Framework_TestCase {
    function testIterationWithoutChildrenIsEmpty() {
        $root = $this->getMock(
            '\Mystique\Common\Ast\Node\Branch',
            array('getNodeChildren', 'getNodeType', 'getNodeAttributes')
        );
        $root->expects($this->once())->method('getNodeChildren')->will($this->returnValue(array()));
        $this->assertEquals(array(), iterator_to_array(new \RecursiveIteratorIterator(new \Mystique\Common\Ast\Iterator($root))));
    }


    function testIterationWillYieldChildElements() {
        $root = $this->getMock(
            '\Mystique\Common\Ast\Node\Branch',
            array('getNodeChildren', 'getNodeType', 'getNodeAttributes')
        );
        $root->expects($this->once())->method('getNodeChildren')->will(
            $this->returnValue(
                array(
                    $child1 = $this->getMock('\Mystique\Common\Ast\Node\Node'),
                    $child2 = $this->getMock('\Mystique\Common\Ast\Node\Node'),
                )
            )
        );
        $iterator = new \Mystique\Common\Ast\Iterator($root);

        $list = array($child1, $child2);
        $i = 0;
        foreach(new \RecursiveIteratorIterator($iterator) as $node) {
            $this->assertEquals($list[$i], $node);
            $i ++;
        }
    }


    function testIterationWillYieldGrandChildElements() {
        $root = $this->getMock(
            'Mystique\Common\Ast\Node\Branch',
            array('getNodeChildren', 'getNodeType', 'getNodeAttributes')
        );
        $root->expects($this->once())->method('getNodeChildren')->will(
            $this->returnValue(
                array(
                    $child1 = $this->getMock('Mystique\Common\Ast\Node\Branch', array('getNodeChildren', 'getNodeType', 'getNodeAttributes')),
                    $child2 = $this->getMock('Mystique\Common\Ast\Node\Branch', array('getNodeChildren', 'getNodeType', 'getNodeAttributes')),
                )
            )
        );
        $child1->expects($this->once())->method('getNodeChildren')->will($this->returnValue(
            array(
                $gc1_1 = $this->getMock('Mystique\Common\Ast\Node\Node'),
                $gc1_2 = $this->getMock('Mystique\Common\Ast\Node\Node'),
            )
        ));
        $child2->expects($this->once())->method('getNodeChildren')->will($this->returnValue(
            array(
                $gc2_1 = $this->getMock('Mystique\Common\Ast\Node\Node'),
                $gc2_2 = $this->getMock('Mystique\Common\Ast\Node\Node'),
            )
        ));
        $iterator = new \Mystique\Common\Ast\Iterator($root);

        // Depth-first is default for RecursiveIteratorIterator
        $list = array($gc1_1, $gc1_2, $gc2_1, $gc2_2, $child1, $child2);
        $i = 0;
        foreach(new \RecursiveIteratorIterator($iterator) as $node) {
            $this->assertEquals($list[$i], $node);
            $i ++;
        }
    }
}