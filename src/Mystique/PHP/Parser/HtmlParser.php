<?php

namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\Html;

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