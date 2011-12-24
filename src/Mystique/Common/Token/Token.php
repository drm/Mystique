<?php

namespace Mystique\Common\Token;

/**
 *
 */
class Token
{
    public $type;
    public $value;


    function __construct($token)
    {
        if (is_array($token)) {
            $this->type = $token[0];
            $this->value = $token[1];
        } else {
            $this->type = $token;
            $this->value = $token;
        }
    }


    function __toString()
    {
        return (string)$this->value;
    }


    function verbose() {
        if(!is_scalar($this->type)) {
            return $this->value;
        }
        if(isset(\Mystique\PHP\Token\Type::$types[$this->type])) {
            return sprintf('[%s "%s"]', \Mystique\PHP\Token\Type::$types[$this->type], str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $this->value));
        }
        return $this->type;
    }


    function match($token, $value = null)
    {
        $ret = false;
        if (is_scalar($token)) {
            $ret = $this->type == $token;
            if ($ret && !is_null($value)) {
                if(is_array($value)) {
                    $ret = in_array($this->value, $value);
                } else {
                    $ret = $this->value == $value;
                }
            }
        } elseif ($token instanceof Token) {
            $ret = ($this->type == $token->type && $this->value == $token->value);
        } elseif (is_array($token)) {
            foreach ($token as $tok) {
                if ($this->match($tok)) {
                    $ret = true;
                    break;
                }
            }
        }
        return $ret;
    }
}