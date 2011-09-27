<?php

namespace Meander\PHP\Token;


class Tokenizer {
    static function tokenize($str) {
        return token_get_all($str);
    }

    
    static function tokenizePhp($str) {
        return array_slice(token_get_all('<?php ' . $str), 1);
    }
}