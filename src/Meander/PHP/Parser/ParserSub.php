<?php
namespace Meander\PHP\Parser;

abstract class ParserSub implements Parser {
    function __construct(ParserBase $parent) {
        $this->parent = $parent;
    }
}