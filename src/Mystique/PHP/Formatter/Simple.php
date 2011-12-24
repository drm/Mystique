<?php

namespace Mystique\PHP\Formatter;

use \Mystique\PHP\Token\Tokenizer;
use \Mystique\PHP\Token\TokenStream;
use \Mystique\Common\Compiler\Compiler;
use \Mystique\PHP\Token\Token;

class Simple implements FormatterInterface {
    protected $indent = '    ';
    protected $indentSize = 0;

    /**
     * @var \Mystique\PHP\Compiler
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
        if(in_array($stream->current()->value, array(
            '=', '+', '&&', '-', '{', '?', ':', '.', '==', '+=', '-=', '/=', '*='
        ))) {
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
        $current = $stream->current();
        if ($current->type == T_OPEN_TAG) {
            $this->_write("\n");
        } elseif ($current->value == '{') {
            $this->indent();
            $this->_write("\n");
        } elseif(in_array($current->value, array('if', 'foreach', 'while', 'elseif'))) {
            $this->_write(" ");
        } elseif(($current->value == ";" || $current->value == "}") && substr($this->compiler->result, -1) != "\n") {
            $this->_write("\n");
        } elseif(in_array($current->value, array(
            ',', '=', '+', '=', '+', '&&', '||', '-', '{', '?', ':', '.', '==', '+=', '-=', '/=', '*='
        ))) {
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