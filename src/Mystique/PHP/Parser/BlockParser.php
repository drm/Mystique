<?php

namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\Raw;
use Mystique\Common\Util\PairMatcher;

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