<?php

class Context {
    function __construct(TokenStream $stream, $index) {
        $this->stream = $stream;
        $this->index = $index;
    }


    function setFile($fileName) {
        $this->file = $fileName;
    }
}