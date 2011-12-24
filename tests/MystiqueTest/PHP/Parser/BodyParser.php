<?php
namespace MystiqueTest\PHP\Parser;
use \Mystique\PHP\Token\TokenStream;

class BodyParser extends \Mystique\PHP\Parser\ParserBase {
    function __construct()
    {
        parent::__construct();
        $this->parsers[]= new \Mystique\PHP\Parser\BlockParser('{');
    }

    function parse(TokenStream $stream)
    {
    }

    function match(TokenStream $stream)
    {
    }
}

