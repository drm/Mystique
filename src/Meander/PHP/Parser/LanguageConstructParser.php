<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\LanguageConstruct;

class LanguageConstructParser extends ParserSub {
    public static $types = array(
        T_INCLUDE,
        T_INCLUDE_ONCE,
        T_REQUIRE,
        T_REQUIRE_ONCE,
        T_RETURN,
        T_THROW,
        T_GLOBAL,
        T_STATIC,
        T_ECHO,
        T_PRINT,
        T_GOTO,
        T_EXIT,
        T_BREAK,
        T_CONTINUE
    );

    public static $mul = array(
        T_STATIC,
        T_GLOBAL,
        T_ECHO
    );

    public static $optionalArgs = array(
        T_EXIT,
        T_BREAK,
        T_CONTINUE,
        T_RETURN,
    );

    function parse(TokenStream $stream) {
        $token = $stream->expect(self::$types);
        if(in_array($token->type, self::$mul)) {
            $expr = array();
            $expr[] = $this->parent->parseExpression($stream);
            while($stream->match(',')) {
                $stream->next();
                $expr[]= $this->parent->parseExpression($stream);
            }
            $expr = new \Meander\PHP\Node\ExprList($expr);
        } else {
            if(in_array($token->type, self::$optionalArgs) && $stream->match(';')) {
                $expr = null;
            } else {
                $expr = $this->parent->parseExpression($stream);
            }
        }
        $stream->expect(';');
        return new LanguageConstruct($token->value, $expr);
    }

    function match(TokenStream $stream) {
        return $stream->match(self::$types);
    }
}