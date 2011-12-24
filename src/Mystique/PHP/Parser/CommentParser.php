<?php
namespace Mystique\PHP\Parser;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\Comment;
use Mystique\Common\Parser\ParserSub;

class CommentParser extends ParserSub {
    function parse(TokenStream $stream)
    {
        return new Comment($stream->expect(array(T_COMMENT, T_DOC_COMMENT))->value);
    }

    function match(TokenStream $stream)
    {
        return $stream->match(array(T_COMMENT, T_DOC_COMMENT));
    }
}