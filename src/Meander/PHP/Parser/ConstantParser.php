<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

class ConstantParser extends ParserSub {
    function parse(TokenStream $stream)
    {
        // TODO: Implement parse() method.
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_CONST);
    }
}