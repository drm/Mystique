<?php

namespace MystiqueTest\Common\Inspector;

class FilterIteratorTest extends \PHPUnit_Framework_TestCase {
    function testIterationWillApplyFilterToElements() {
        $nodes = array(
            $this->getMock('Mystique\Common\Ast\Node\Node'),
            $this->getMock('Mystique\Common\Ast\Node\Node'),
            $this->getMock('Mystique\Common\Ast\Node\Node')
        );

        $filter = $this->getMock('Mystique\Common\Inspector\Matcher\MatcherInterface', array('match'));
        $iterator = new \Mystique\Common\Inspector\FilterIterator(new \ArrayIterator($nodes), $filter);
        $filter->expects($this->at(0))->method('match')->will($this->returnValue(false));
        $filter->expects($this->at(1))->method('match')->will($this->returnValue(true));
        $filter->expects($this->at(2))->method('match')->will($this->returnValue(false));

        $this->assertEquals(array(1 => $nodes[1]), iterator_to_array($iterator));
    }
}