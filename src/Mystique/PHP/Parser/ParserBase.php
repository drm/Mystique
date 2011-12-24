<?php

namespace Mystique\PHP\Parser;

use Mystique\Common\Ast\Node\NodeList;
use \Mystique\PHP\Token\TokenStream;
use \Mystique\PHP\Node\Raw;
use Mystique\Common\Ast\Node\Node;

abstract class ParserBase implements Parser
{
    protected $parsers = array();
    protected $expressionParser = null;

    function __construct()
    {
        $this->stack = array();
    }


    function subparse(TokenStream $stream, $callback)
    {
        if ($callback !== true && !is_callable($callback)) {
            throw new \InvalidArgumentException("Callback is not callable");
        }
        array_push($this->stack, new NodeList());
        while ($stream->valid()) {
            $haveMatch = false;
            foreach ($this->parsers as $parser) {
                if ($parser->match($stream)) {
                    $node = $parser->parse($stream);
                    if (!$node instanceof Node) {
                        throw new \UnexpectedValueException('Parser ' . get_class($parser) . ' does not return expected type Node');
                    }
                    end($this->stack)->append($node);
                    $haveMatch = true;
                    break;
                }
            }
            if ($callback === true || call_user_func($callback, $stream)) {
                break;
            }
            if (!$haveMatch) {
                $stream->err($stream->current(), "Unhandled element");
            }
        }
        return array_pop($this->stack);
    }


    function getParser($name)
    {
        return $this->parsers[$name];
    }


    function parseExpression(TokenStream $stream)
    {
        return $this->getExpressionParser()->parse($stream);
    }


    function parseName(TokenStream $stream)
    {
        return $this->getExpressionParser()->parseName($stream);
    }

    /**
     * @return \Mystique\PHP\Parser\ExpressionParser
     */
    function getExpressionParser()
    {
        if (null === $this->expressionParser) {
            $this->expressionParser = new ExpressionParser($this);
        }
        return $this->expressionParser;
    }


    function parseStatement(TokenStream $stream)
    {
        if ($this->parsers['compound']->match($stream)) {
            return $this->parsers['compound']->parse($stream);
        } else {
            return $this->parsers['statement']->parse($stream);
        }
    }
}