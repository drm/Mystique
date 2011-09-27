<?php

namespace Meander\PHP\Token;


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
        if(isset(Type::$types[$this->type])) {
            return sprintf('[%s "%s"]', Type::$types[$this->type], str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $this->value));
        }
        return $this->type;
    }


    function match($token, $value = null)
    {
        $ret = false;
        if (is_scalar($token)) {
            $ret = $this->type == $token;
            if ($ret && !is_null($value)) {
                $ret = $this->value == $value;
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