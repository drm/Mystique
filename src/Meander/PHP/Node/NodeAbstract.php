<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Token\TokenAware;

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

    function startTokenContext(\Meander\PHP\Token\TokenStream $stream)
    {
        $this->tokenContext = array(
            'stream'    => $stream,
            'start'     => $stream->key(),
            'end'       => null
        );
    }

    function endTokenContext(\Meander\PHP\Token\TokenStream $stream) {
        $this->tokenContext['end']= $stream->key();
    }


    /**
     * @return \Meander\PHP\Token\TokenSlice
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