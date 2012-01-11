<?php

namespace Mystique\PHP\Parser;

use Mystique\Common\Token\TokenStream;

class AnnotationParser extends \Mystique\Common\Parser\ParserSub {
    function parse(TokenStream $stream) {
        $comment = $stream->expect(T_DOC_COMMENT, T_COMMENT);
        var_dump($comment->value);
    }

    function match(TokenStream $stream) {
        return $stream->match(array(T_DOC_COMMENT, T_COMMENT));
    }
}