<?php

namespace Meander\PHP\Formatter;

use \Meander\PHP\Token\Tokenizer;
use \Meander\PHP\Token\TokenStream;

class Deflate implements FormatterInterface {
    function __construct($stripComments = true) {
        $this->stripComments = $stripComments;
    }


    function format($code) {
        $compiler = new \Meander\Compiler\Compiler();
        foreach(new TokenStream(Tokenizer::tokenize($code)) as $token) {
            if($this->stripComments && in_array($token->type, array(T_COMMENT, T_DOC_COMMENT))) {
                continue;
            }
            if($token->type != T_WHITESPACE) {
                $compiler->write($token->value);
            }
        }
        return $compiler->result;
    }
}