<?php
namespace Meander\PHP\Token;

class TokenSlice {
    protected $stream = null;

    function __construct(TokenStream $stream, $left, $length) {
        $this->stream = $stream;
        $this->left = $left;
        $this->length = $length;
    }


    function __toString() {
        return $this->stream->substr($this->left, $this->length);
    }
}