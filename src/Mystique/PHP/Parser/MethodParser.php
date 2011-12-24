<?php
namespace Mystique\PHP\Parser;

use \Mystique\PHP\Token\TokenStream;
use \Mystique\PHP\Node\MethodNode;

class MethodParser extends FunctionParser {
    public static $prefixes = array(T_FINAL, T_ABSTRACT, T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED, T_DOC_COMMENT);


    function parse(TokenStream $stream)
    {
        $method = new MethodNode();

        while($stream->match(self::$prefixes)) {
            switch($stream->expect(self::$prefixes)->type) {
                case T_FINAL:
                    $method->setFinal(true);
                    break;
                case T_ABSTRACT:
                    $method->setAbstract(true);
                    break;
                case T_STATIC:
                    $method->setStatic(true);
                    break;
                case T_PUBLIC:
                    $method->setVisibility(\Mystique\PHP\Node\MethodDeclaration::IS_PUBLIC);
                    break;
                case T_PRIVATE:
                    $method->setVisibility(\Mystique\PHP\Node\MethodDeclaration::IS_PRIVATE);
                    break;
                case T_PROTECTED:
                    $method->setVisibility(\Mystique\PHP\Node\MethodDeclaration::IS_PROTECTED);
                    break;
                default:
                    throw new \LogicException("Unreachable code...?");
            }
        }

        $stream->expect(T_FUNCTION);
        $method->setName(new \Mystique\PHP\Node\Name($stream->expect(T_STRING)->value));
        $method->setParameters($this->parseParameterList($stream));

        if($stream->match(';')) {
            $stream->next();
            if(isset($method->children[1])) {
                unset($method->children[1]);
            }
        } else {
            $stream->expect('{');
            $method->setDefinition($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
            $stream->expect('}');
        }
        return $method;
    }

    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_FUNCTION, null, self::$prefixes);
    }
}