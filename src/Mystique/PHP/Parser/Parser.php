<?php

namespace Mystique\PHP\Parser;

use Mystique\Common\Token\TokenStream;

interface Parser {
    function parse(TokenStream $stream);
    function match(TokenStream $stream);
}