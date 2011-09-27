<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Node\UseNode;
use \Meander\PHP\Token\TokenStream;


class UseParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_USE);
        $name = $this->parent->parseExpression($stream);
        $alias = null;
        if($stream->match(T_AS)) {
            $stream->next();
            $alias = $this->parent->parseExpression($stream);
        }
        $stream->expect(';');
        return new UseNode($name, $alias);
    }

    
    function match(TokenStream $stream)
    {
        return $stream->match(T_USE);
    }
}