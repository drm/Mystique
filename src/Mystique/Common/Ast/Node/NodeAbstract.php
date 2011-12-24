<?php

namespace Mystique\Common\Ast\Node;

use Mystique\Common\Token\TokenAware;
use Mystique\Common\Token\TokenStream;

abstract class NodeAbstract implements Node, TokenAware {
    protected $attributes = array(), $tokenContext = array();

    function getNodeType() {
        $className = get_class($this);
        if(preg_match('/([^\\\\]+)$/', $className, $m)) {
            return $m[1];
        }
        return $className;
    }



    function getNodeAttributes() {
        return $this->attributes;
    }

    function startTokenContext(TokenStream $stream)
    {
        $this->tokenContext = array(
            'stream'    => $stream,
            'start'     => $stream->key(),
            'end'       => null
        );
    }

    function endTokenContext(TokenStream $stream) {
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