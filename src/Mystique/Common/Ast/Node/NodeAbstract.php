<?php

namespace Mystique\Common\Ast\Node;

use Mystique\Common\Token\TokenAware;
use Mystique\Common\Token\TokenStream;

abstract class NodeAbstract implements Node, TokenAware {
    protected $attributes = array(), $tokenContext = array();

    function getNodeType() {
        $className = get_class($this);
        if(preg_match('/([^\\\\]+)$/', $className, $m)) {
            $className = $m[1];
        }
        if(substr($className, -4) == 'Node') {
            $className = substr($className, 0, -4);
        }
        return $className;
    }



    function getNodeAttributes() {
        return $this->attributes;
    }

    function startTokenContext(TokenStream $stream, $offset = null)
    {
        $this->tokenContext = array(
            'stream'    => $stream,
            'start'     => is_null($offset) ? $stream->key() : $offset,
            'end'       => null
        );
    }


    function endTokenContext(TokenStream $stream) {
        if(!isset($this->tokenContext['start'])) {
            throw new \LogicException("Token context ended, but the start was never registered for element [" . get_class($this) . "]");
        }
        $this->tokenContext['end']= $stream->key();
    }


    /**
     * @return \Mystique\PHP\Token\TokenSlice
     */
    function getTokenSlice() {
        if(isset($this->tokenContext['stream'])) {
            return $this->tokenContext['stream']->slice(
                $this->tokenContext['start'],
                $this->tokenContext['end'] - $this->tokenContext['start']
            );
        }
    }
}