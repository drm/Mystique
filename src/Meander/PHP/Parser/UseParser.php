<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Node\UseNode;
use \Meander\PHP\Token\TokenStream;


class UseParser extends ParserSub {
    function parse(TokenStream $stream) {
        $node = new \Meander\PHP\Node\UseDeclaration();
        $stream->expect(T_USE);

        do {
            $item = $this->parseItem($stream);
            $node->children->append($item);
        } while($stream->match(',') && $stream->expect(','));

        $stream->expect(';');
        return $node;
    }


    function parseItem(TokenStream $stream) {
        $name = $this->parent->getExpressionParser()->parseName($stream);
        $alias = null;
        if($stream->match(T_AS)) {
            $stream->next();
            $alias = $this->parent->parseExpression($stream);
        }
        return new UseNode($name, $alias);
    }

    
    function match(TokenStream $stream)
    {
        return $stream->match(T_USE);
    }
}