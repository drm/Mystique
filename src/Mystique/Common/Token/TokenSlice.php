<?php

namespace Mystique\Common\Token;

class TokenSlice {
    function __construct(TokenStream $stream, $left, $length) {
        $this->stream = $stream;
        $this->left = $left;
        $this->length = $length;
    }


    function __toString() {
        return $this->stream->substr($this->left, $this->length);
    }


    function getLineNumber() {
        return $this->stream->getLineNumber($this->left);
    }

    function getLine() {
        return $this->stream->getLine($this->left);
    }
}