<?php

namespace Mystique\Common\Parser;
use Mystique\Common\Token\TokenStream;

interface ExpressionParser extends Parser {
    function parseValue(TokenStream $stream);
}