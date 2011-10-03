<?php
namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Comment;

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