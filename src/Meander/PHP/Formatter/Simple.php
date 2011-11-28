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
        $stream = new TokenStream(Tokenizer::tokenize($code));
        foreach($stream as $token) {
            $this->_before($stream);
            if($token->type != T_WHITESPACE) {
                $this->_write($token->value);
            }
            $this->_after($stream);
        }
        return $this->compiler->result;
    }


    function indent() {
        $this->indentSize ++;
    }


    function unindent() {
        $this->indentSize --;
    }


    function _before(TokenStream $stream) {
        if(in_array($stream->current()->value, array('=', '+', '&&', '-', '{', '?', ':'))) {
            $this->_write(' ');
        }
        if($stream->current()->value == "}") {
            $this->unindent();
            if(substr($this->compiler->result, -1) != "\n") {
                $this->_write("\n");
            }
        }
    }


    function _after(TokenStream $stream) {
        if ($stream->current()->type == T_OPEN_TAG) {
            $this->_write("\n");
        } elseif ($stream->current()->value == '{') {
            $this->indent();
            $this->_write("\n");
        } elseif(in_array($stream->current()->value, array('if', 'foreach', 'while'))) {
            $this->_write(" ");
        } elseif(($stream->current()->value == ";" || $stream->current()->value == "}") && substr($this->compiler->result, -1) != "\n") {
            $this->_write("\n");
        } elseif(in_array($stream->current()->value, array(',', '=', '+', '&&', '-'))) {
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