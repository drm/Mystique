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
        T_RETURN
    );

    function parse(TokenStream $stream) {
        $type = $stream->expect(self::$types)->value;
        $expr = $this->parent->parseExpression($stream);
        $stream->expect(';');
        return new LanguageConstruct($type, $expr);
    }

    function match(TokenStream $stream) {
        return $stream->match(self::$types);
    }
}