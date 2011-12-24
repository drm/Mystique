<?php
namespace MystiqueTest\PHP\Parser;
use \Mystique\Common\Token\TokenStream;
use Mystique\Common\Parser\ParserBase;

class BodyParser extends ParserBase {
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

