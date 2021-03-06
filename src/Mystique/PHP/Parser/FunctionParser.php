<?php

namespace Mystique\PHP\Parser;

use \Mystique\Common\Parser\ParserSub;
use \Mystique\Common\Parser\ParserBase;
use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\FunctionNode;
use \Mystique\PHP\Node\ParameterDefinition;
use \Mystique\PHP\Node\Variable;

class FunctionParser extends ParserSub {
    function __construct(ParserBase $parent)
    {
        parent::__construct($parent);
    }


    function parse(TokenStream $stream)
    {
        $def = new FunctionNode();
        $def->startTokenContext($stream);
        $stream->expect(T_FUNCTION);
        if($stream->match('&')) {
            $stream->next();
            $def->setByRef(true);
        }
        $name = $stream->expect(T_STRING);
        $def->setName(new \Mystique\PHP\Node\Name($name->value));

        $def->setParameters($this->parseParameterList($stream));
        if($stream->match(';')) {
            $stream->next();
        } else {
            $stream->expect('{');
            $def->setDefinition($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
            $stream->expect('}');
        }
        $def->endTokenContext($stream);
        return $def;
    }


    function parseParameterList(TokenStream $stream) {
        $stream->expect('(');
        $params = new \Mystique\PHP\Node\ParameterDefinitionList();

        if(!$stream->match(')')) {
            while($stream->valid()) {
                $param = new ParameterDefinition();
                if($stream->match(array(T_STRING, T_NS_SEPARATOR, T_ARRAY))) {
                    $name = $this->parent->getExpressionParser()->parseName($stream);
                    $param->setTypeHint($name);
                }
                if($stream->match('&')) {
                    $stream->next();
                    $param->setByRef(true);
                }
                $token = $stream->expect(array(T_VARIABLE));
                $param->setName(new Variable(substr($token->value, 1)));
                if($stream->match('=')) {
                    $stream->next();
                    $param->setDefaultValue($this->parent->parseExpression($stream));
                }
                $params->add($param);
                if($stream->match(')')) {
                    break;
                }
                $stream->expect(',');
            }
        }
        $stream->expect(')');
        return $params;
    }


    function match(TokenStream $stream)
    {
        return $stream->match(T_FUNCTION);
    }
}