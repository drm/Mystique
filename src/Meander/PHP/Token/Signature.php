<?php

namespace Meander\PHP\Token;


class Signature {
    function __construct(Token $token, $modifiers = array()) {
        $this->token = $token;
        $this->modifiers = $modifiers;
    }
}