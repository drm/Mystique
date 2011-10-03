<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Node\SwitchNode;
use \Meander\PHP\Token\TokenStream;

class SwitchParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_SWITCH);
        $stream->expect('(');
        $expression = $this->parent->parseExpression($stream);
        $stream->expect(')');

        $parser = new BlockParser('{');
        ;
        return new SwitchNode($expression, $parser->parse($stream));
    }

    function match(TokenStream $stream) {
        return $stream->match(T_SWITCH);
    }
}