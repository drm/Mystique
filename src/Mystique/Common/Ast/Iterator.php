<?php

namespace Mystique\Common\Ast;

class Iterator extends \ArrayIterator implements \RecursiveIterator {
    public function __construct(Node\Branch $root) {
        parent::__construct($root->getNodeChildren());
    }


    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns if an iterator can be created fot the current entry.
     * @link http://php.net/manual/en/recursiveiterator.haschildren.php
     * @return bool true if the current entry can be iterated over, otherwise returns false.
     */
    public function hasChildren()
    {
        return $this->current() instanceof Node\Branch;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Returns an iterator for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.getchildren.php
     * @return RecursiveIterator An iterator for the current entry.
     */
    public function getChildren() {
        return new self($this->current());
    }
}