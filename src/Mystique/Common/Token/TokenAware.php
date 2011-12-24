<?php
namespace Mystique\Common\Token;

use Mystique\Common\Token\TokenStream;

interface TokenAware {
    function startTokenContext(TokenStream $stream);
    function endTokenContext(TokenStream $stream);
    function getTokenSlice();
}