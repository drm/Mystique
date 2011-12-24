<?php
namespace Mystique\PHP\Parser;

use \Mystique\PHP\Token\TokenStream;
use \Mystique\PHP\Node\ForNode;

class ForParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_FOR);
        $stream->expect('(');
        $expressions = array(null, null, null);

        foreach(array_keys($expressions) as $i) {
            $delim = ($i != 2 ? ';' : ')');
            if(!$stream->match($delim)) {
                $expressions[$i] = $this->parent->getExpressionParser()->parseList($stream);
            }
            $stream->expect($delim);
        }
        return new ForNode($expressions, $this->parent->subparse($stream, true)->peek());
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_FOR);
    }
}