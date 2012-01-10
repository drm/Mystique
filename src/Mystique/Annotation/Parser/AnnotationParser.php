<?php

namespace Mystique\Annotation\Parser;

use Mystique\Annotation\Node\AnnotationNode;
use Mystique\Annotation\Node\NameValuePair;
use Mystique\Common\Token\TokenStream;
use Mystique\Concept\Node\Comment;

class AnnotationParser implements \Mystique\Common\Parser\Parser {
    function parse(TokenStream $stream) {
        $stream->expect('@');
        $node = new AnnotationNode();
        $name = $stream->expect('name');
        $node->setName($name->value);

        if($stream->valid() && $stream->match('(')) {
            $stream->expect('(');
            $args = new \Mystique\Annotation\Node\ArgumentsNode();

            while(!$stream->match(')')) {
                if($stream->match('name')) {
                    $args->children->append($this->parseNameValuePair($stream));
                } else {
                    $args->children->append($this->parseValue($stream));
                }
                if(!$stream->match(')')) {
                    $stream->expect(',');
                }
            }

            $node->setArgs($args);
            $stream->expect(')');
        }
        return $node;
    }


    function parseNameValuePair($stream) {
        $pair = new NameValuePair();
        $pair->setName($stream->expect('name')->value);
        $stream->expect('=');
        $pair->setValue($this->parseValue($stream));
        return $pair;
    }


    function parseValue($stream) {
        if($stream->match('{')) {
            $ret = new \Mystique\Annotation\Node\Dict();
            $stream->next();
            while(!$stream->match('}')) {
                $ret->children->append($this->parseNameValuePair($stream));
                if(!$stream->match('}')) {
                    $stream->expect(',');
                }
            }
            $stream->expect('}');
            return $ret;
        }
        if($stream->match('[')) {
            $ret = new \Mystique\Annotation\Node\ListNode();
            $stream->next();
            while(!$stream->match(']')) {
                $ret->children->append($this->parseValue($stream));
                if(!$stream->match(']')) {
                    $stream->expect(',');
                }
            }
            $stream->expect(']');
        }
        if ($stream->match(array('string', 'number'))) {
            $ret = new \Mystique\Annotation\Node\Scalar($stream->current());
            $stream->next();
        }
        if ($stream->match('@')) {
            $ret = $this->parse($stream);
        }
        return $ret;
    }


    function match(TokenStream $stream)
    {
        return $stream->match('@');
    }
}