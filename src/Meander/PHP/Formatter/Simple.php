<?php

namespace Meander\PHP\Formatter;

use \Meander\PHP\Token\Tokenizer;
use \Meander\PHP\Token\TokenStream;
use \Meander\Compiler\Compiler;
use \Meander\PHP\Token\Token;

class Simple implements FormatterInterface {
    protected $indent = '    ';
    protected $indentSize = 0;
    /**
     * @var \Meander\PHP\Compiler
     */
    protected $compiler;

    function format($code) {
        $this->compiler = new Compiler();
        foreach(new TokenStream(Tokenizer::tokenize($code)) as $token) {
            $this->_before($token);
            if($token->type != T_WHITESPACE) {
                $this->_write($token->value);
            }
            $this->_after($token);
        }
        return $this->compiler->result;
    }


    function indent() {
        $this->indentSize ++;
    }


    function unindent() {
        $this->indentSize --;
    }


    function _before(Token $token) {
        if(in_array($token->value, array('=', '+', '&&', '-', '{'))) {
            $this->_write(' ');
        }
        if($token->value == "}") {
            $this->unindent();
            if(substr($this->compiler->result, -1) != "\n") {
                $this->_write("\n");
            }
        }
    }


    function _after($token) {
        if ($token->type == T_OPEN_TAG) {
            $this->_write("\n");
        } elseif ($token->value == '{') {
            $this->indent();
            $this->_write("\n");
        } elseif(in_array($token->value, array('if', 'foreach', 'while'))) {
            $this->_write(" ");
        } elseif($token->value == ";" && substr($this->compiler->result, -1) != "\n") {
            $this->_write("\n");
        } elseif(in_array($token->value, array(',', '=', '+', '&&', '-'))) {
            $this->_write(' ');
        }

    }


    function _write($value) {
        if($this->indentSize && substr($this->compiler->result, -1) == "\n" && $value != "\n") {
            $this->compiler->write(str_repeat($this->indent, $this->indentSize));
        }
        $this->compiler->write($value);
    }
}