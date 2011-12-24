<?php

namespace Mystique\Common\Token;

use Iterator;
use ArrayAccess;
use Countable;
use OutOfBoundsException;
use UnexpectedValueException;
use LogicException;

class TokenStream implements Iterator, Countable
{
    protected $ignoreTypes = array();
    protected $ptr;

    function __construct(array $tokens = array(), array $ignore = array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT))
    {
        $this->tokens = $tokens;
        $this->ignoreTypes = $ignore;
        $this->rewind();
    }


    function ignore($tokenType)
    {
        $this->ignoreTypes[] = $tokenType;
        $this->rewind();
    }


    function peek($direction = 1)
    {
        $index = $this->ptr + ($direction < 0 ? -1 : 1);
        while ($this->isValidIndex($index) && $this->tokenAt($index)->match($this->ignoreTypes)) {
            $index += $direction;
        }
        if ($this->isValidIndex($index)) {
            return $this->tokenAt($index);
        }
        throw new OutOfBoundsException("No valid token at offset {$index}");
    }


    function peekBack($direction = 1)
    {
        return $this->peek(-$direction);
    }


    function next()
    {
        $this->forward();
        $this->_skipAhead();
    }


    function _skipAhead()
    {
        while ($this->valid() && $this->current()->match($this->ignoreTypes)) {
            $this->forward();
        }
    }


    function forward($length = 1)
    {
        $this->move($length);
    }


    function forwardUntil($type) {
        while(!$this->match($type)) {
            $this->next();
        }
        $this->_skipAhead();
    }


    function move($length)
    {
        $this->ptr += $length;
        $this->_checkPtr();
    }

    private function _checkPtr()
    {
        if ($this->ptr > count($this)) {
            throw new OutOfBoundsException("Trying to advance pointer beyond end of stream");
        }
        if ($this->ptr < 0) {
            throw new OutOfBoundsException("Trying to advance pointer under beginning of stream");
        }
    }


    function back($num = 1)
    {
        $this->move(-$num);
    }


    function valid()
    {
        return $this->isValidIndex($this->ptr);
    }


    function isValidIndex($i)
    {
        return isset($this->tokens[$i]);
    }


    function remove($index)
    {
        array_splice($this->tokens, $index, 1);
    }


    /**
     *
     * @return Token
     */
    function tokenAt($index)
    {
        if (!$this->tokens[$index] instanceof Token) {
            $this->tokens[$index] = new Token($this->tokens[$index]);
        }
        return $this->tokens[$index];
    }

    /**
     * @return Token
     */
    public function current()
    {
        return $this->tokenAt($this->ptr);
    }


    public function key()
    {
        return $this->ptr;
    }


    public function rewind()
    {
        $this->ptr = 0;
        $this->_skipAhead();
    }


    public function insert(Token $token, $before = false)
    {
        array_splice($this->tokens, $this->ptr + ($before ? 0 : 1), 0, array($token));
        $this->forward(1);
    }


    public function inject(TokenStream $stream, $before = false)
    {
        array_splice($this->tokens, $this->ptr + ($before ? 0 : 1), 0, iterator_to_array($stream));
        $this->forward(count($stream));
    }


    /**
     * @param $token
     * @param null $value
     * @return Token
     */
    public function expect($token, $value = null)
    {
        if (!$this->valid()) {
            throw new LogicException("Unexpected end of stream");
        }
        $this->assert($token, $value);
        $ret = $this->current();
        $this->next();
        return $ret;
    }

    public function err($token, $value = null) {
        if(is_array($token)) {
            $expect = '';
            foreach($token as $i => $t) {
                $expect == '' or $expect .= ($i == count($token) -1) ? ' or ' : ', ';
                $expect .= isset(Type::$types[$t]) ? Type::$types[$t] : "'$t'";
            }
        } else {
            $expected = new Token($token, $value);
            $expect = $expected->verbose();
        }

        $msg = sprintf(
            "Unexpected token %s; expected %s.\nNear line %d:\n%s\n",
            $this->current()->verbose(),
            $expect,
            $this->getLineNumber(),
            $this->getLine()
        );
        throw new UnexpectedValueException($msg);
    }


    public function assert($token, $value = null) {
        if (!$this->match($token, $value)) {
            $this->err($token, $value);
        }
    }


    public function match($token, $value = null)
    {
        return $this->current()->match($token, $value);
    }



    public function matchSignature($token, $value = null, $allowPrefixes = array()) {
        $match = false;
        $save = $this->ptr;
        $modifiers = array();
        while($this->match($allowPrefixes)) {
            $modifiers[$this->current()->type]= $this->current();
            $this->next();
        }
        if($this->match($token, $value)) {
            $match = $this->current();
        } 
        $this->ptr = $save;
        return (bool)$match;
    }


    function slice($left, $length = null) {
        return new TokenSlice($this, $left, $length);
//        return array_map(
//            function ($element) use($self)
//            {
//                return $self->tokenAt($element);
//            },
//            array_slice(array_keys($this->tokens), $left, $length)
//        );
    }


    function substr($left, $length = null) {
        $self = $this;
        $ret = array_reduce(
            array_slice(array_keys($this->tokens), $left, $length),
            function ($current, $element) use ($self)
            {
                return $current . $self->tokenAt($element)->value;
            },
            ''
        );
        return $ret;
    }


    public function count()
    {
        return count($this->tokens);
    }


    public function __toString()
    {
        return $this->substr(0);
    }


    function getLine() {
        $fn = function($t) {
            return $t->type == T_WHITESPACE && strpos($t->value, "\n") !== false;
        };
        $start = $this->nearest($fn, true);
        $end = $this->nearest($fn);

        return preg_replace('/(?:.*\n)?(.*)/', '$1', rtrim($this->substr($start, $end - $start)));
    }


    function getLineNumber() {
        return substr_count($this->substr(0, $this->key()), "\n") +1;
    }


    function nearest($matcher, $reverse = false) {
        for($i = $this->key(); $reverse ? $i > 0 : $i < $this->count() -1; $i += ($reverse ? -1 : 1)) {
            if($matcher($this->tokenAt($i))) {
                break;
            }
        }
        return $i;
    }



//
//
//    function getContext($index = -1) {
//        if($index === -1) {
//            $index = $this->key();
//        }
//        return (string)$this->substr(max(0, $index, min($this->count(), $index + 2)));
//    }
}