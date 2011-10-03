<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

class PropertyParser extends ParserSub {
    function parse(TokenStream $stream)
    {
        $stream->forwardUntil(';');
        $stream->expect(';');

        return new \Meander\PHP\Node\PropertyDefinition('TODO');
    }

    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_VARIABLE, null, array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED));
    }
}