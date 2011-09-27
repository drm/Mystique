<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\HtmlNode;

class HtmlParser implements Parser {
    function parse(TokenStream $stream) {
        return new HtmlNode($stream->next()->value);
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_INLINE_HTML);
    }
}