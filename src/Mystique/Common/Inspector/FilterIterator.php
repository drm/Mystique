<?php
namespace Mystique\Common\Inspector;

use Iterator;

class FilterIterator extends \FilterIterator {
    function __construct(Iterator $iterator, Matcher\MatcherInterface $filter) {
        parent::__construct($iterator);
        $this->filter = $filter;
    }

    final function accept() {
        return $this->filter->match(parent::current());
    }
}
