<?php

namespace Mystique\PHP\Token;

use UnexpectedValueException;

class PairMatcher {
    public static $map = array(
        '{' => '}',
        '[' => ']',
        '(' => ')'
    );


    static function parenOf($type) {
        if($type instanceof Token) {
            $type = $type->type;
        }
        if(!isset(self::$map[$type])) {
            throw new UnexpectedValueException('Unexpected paren type ' . $type);
        }
        return self::$map[$type];
    }

    static function skipToParen(TokenStream $stream, Token $left = null) {
        if(is_null($left)) {
            $left = $stream->current();
            $stream->next();
        }
        $right = self::parenOf($left);
        $depth = 0;

        while($stream->valid()) {
            $n = $stream->current();
            if($n->match($left)) {
                $depth ++;
            } elseif($n->match($right)) {
                if($depth == 0) {
                    break;
                }
                $depth --;
            }
            $stream->next();
        }
        if($stream->valid()) {
            return $stream->current();
        }
        throw new UnexpectedValueException('Unexpected end of stream while looking for paren');
    }
}