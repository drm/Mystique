<?php
namespace Mystique\PHP\Parser;

use \Mystique\PHP\Node\UseNode;
use \Mystique\PHP\Token\TokenStream;


class UseParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_USE);
        $list = new \Mystique\PHP\Node\ExprList();
        do {
            $item = $this->parseItem($stream);
            $list->children->append($item);
        } while($stream->match(',') && $stream->expect(','));

        $stream->expect(';');
        return new \Mystique\PHP\Node\UseDeclaration('use', $list);
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