<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\FunctionDefinition;
use \Meander\PHP\Node\ParameterDefinition;

class FunctionParser extends ParserBase {
    function __construct()
    {
        parent::__construct();
        $this->parsers[]= new BlockParser('{');
    }


    function parse(TokenStream $stream)
    {
        $def = new FunctionDefinition();

        $stream->expect(T_FUNCTION);
        $name = $stream->expect(T_STRING);
        $def->setName($name->value);
        $stream->expect('(');
        $params = new \Meander\PHP\Node\ParameterDefinitionList();
        while($stream->valid()) {
            $token = $stream->expect(array(')', T_VARIABLE, T_STRING, T_NS_SEPARATOR));
            if($token->type == ')') {
                break;
            }
            if($token->type == T_NS_SEPARATOR) {
                throw new \Exception("Unsupported");
            }

            if($token->type == T_STRING) {
                $typeHint = $token->value;
                $token = $stream->expect(T_VARIABLE);
            } else {
                $typeHint = null;
            }
            $def->addParameter($param = new ParameterDefinition(substr($token->value, 1)));
            if($typeHint) {
                $param->setTypeHint($typeHint);
            }
            if($stream->match('=')) {
                throw new \Exception("Unsupported");
                $stream->next();
                $param->setDefaultValue($this->parseExpression($stream));
            }
            if($stream->expect(array(',', ')'))->type == ')') {
                break;
            }
        }
        $this->subparse($stream, true);
        $def->setRawBody($this->body->peek());
        return $def;
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_FUNCTION);
    }

}