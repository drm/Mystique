<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Html;

class HtmlParser implements Parser {
    function parse(TokenStream $stream) {
        $stream->expect(T_INLINE_HTML);
        return new Html($stream->current()->value);
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_INLINE_HTML);
    }
}