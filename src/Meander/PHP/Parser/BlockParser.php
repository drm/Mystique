<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Raw;
use \Meander\PHP\Token\PairMatcher;

class BlockParser implements Parser {
    function __construct($type) {
        $this->type = $type;
    }
    

    function parse(TokenStream $stream) {
        $stream->assert($this->type);
        $left = $stream->key();
        PairMatcher::skipToParen($stream);
        $stream->expect(PairMatcher::parenOf($this->type));
        $ret = new Raw($stream->substr($left, $stream->key() - $left));
        return $ret;
    }
    

    function match(TokenStream $stream) {
        return $stream->match($this->type);
    }
}