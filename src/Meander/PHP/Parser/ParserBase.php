<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Node\NodeList;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Raw;

abstract class ParserBase implements Parser {
    protected $parsers = array();
    protected $expressionParser = null;
    
    function __construct() {
        $this->stack = array();
    }


    function subparse(TokenStream $stream, $callback) {
        array_push($this->stack, new NodeList());
        while($stream->valid()) {
            $haveMatch = false;
            foreach($this->parsers as $parser) {
                if($parser->match($stream)) {
//                    echo get_class($parser) . ' matches ' . $stream->current()->verbose(), "\n";
                    $node = $parser->parse($stream);
                    if(!$node instanceof \Meander\PHP\Node\Node) {
                        throw new \UnexpectedValueException('Parser ' . get_class($parser) . ' does not return expected type Node');
                    }
                    end($this->stack)->append($node);
                    $haveMatch = true;
                    break;
                }
            }
            if($callback === true || call_user_func($callback, $stream)) {
                break;
            }
            if(!$haveMatch) {
                throw new \RuntimeException("Parser error, unexpected " . $stream->current()->verbose());
            }
        }
        return array_pop($this->stack);
    }


    function getParser($name) {
        return $this->parsers[$name];
    }
    

    function parseExpression(TokenStream $stream) {
        return $this->getExpressionParser()->parse($stream);
    }


    function parseName(TokenStream $stream) {
        return $this->getExpressionParser()->parseName($stream);
    }

    /**
     * @return \Meander\PHP\Parser\ExpressionParser
     */
    function getExpressionParser() {
        if (null === $this->expressionParser) {
            $this->expressionParser = new ExpressionParser();
        }
        return $this->expressionParser;
    }
    

    function parseStatement(TokenStream $stream) {
        if($this->parsers['compound']->match($stream)) {
            return $this->parsers['compound']->parse($stream);
        } else {
            return $this->parsers['statement']->parse($stream);
        }
    }
}