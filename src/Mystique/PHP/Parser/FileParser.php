<?php

namespace Mystique\PHP\Parser;
use \Mystique\Common\Token\TokenStream;

class FileParser extends \Mystique\PHP\Parser\ParserBase {
    function __construct() {
        parent::__construct();
        $this->parsers[] = new PhpParser();
        $this->parsers[] = new HtmlParser();
    }


    function parse(TokenStream $stream) {
        return $this->subparse($stream, function(){ return false; });
    }


    function match(TokenStream $stream) {
        return true;
    }
}