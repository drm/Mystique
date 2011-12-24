<?php

namespace Mystique\PHP\Parser;

use UnexpectedValueException;

use \Mystique\Common\Util\PairMatcher;
use \Mystique\Common\Token\TokenStream;
use \Mystique\Common\Ast\Node\Expr\ExpressionAbstract;
use \Mystique\Common\Ast\Node\Expr\BinaryExpression;
use \Mystique\Common\Ast\Node\Expr\UnaryExpression;
use \Mystique\Common\Ast\Node\Expr\ParenthesizedExpression;
use \Mystique\Common\Ast\Node\Node;
use \Mystique\PHP\Node\TernaryExpression;
use \Mystique\PHP\Node\NestedVariable;
use \Mystique\PHP\Token\Type;
use \Mystique\PHP\Token\Operator;
use \Mystique\PHP\Node\Value;
use \Mystique\PHP\Node\Name;
use \Mystique\PHP\Node\NamespacedName;
use \Mystique\PHP\Node\Call;


class ExpressionParser implements Parser
{
    protected $parsers = array();

    function __construct(ParserBase $parent = null)
    {
        $this->parsers['name'] = new NameParser($parent);
        if ($parent) {
            $this->parsers['closure'] = new ClosureParser($parent);
        }
    }


    function parseSubscript(TokenStream $stream, Node $expression)
    {
        $ret = $expression;

        while ($stream->valid() && $stream->match(Operator::$subscriptOperators)) {
            if ($stream->match('(')) {
                $stream->next();
                if (!$stream->match(')')) {
                    $arguments = $this->parseList($stream, $ret instanceof Name && in_array($ret, array('list', 'array')));
                } else {
                    $arguments = new \Mystique\PHP\Node\ExprList();
                }
                $stream->expect(')');
                $ret = new Call($ret, $arguments);
            } elseif ($stream->match(array(T_DEC, T_INC))) {
                $ret = new \Mystique\PHP\Node\PostUnaryExpression(new Operator($stream->current()), $ret);
                $stream->next();
            } else {
                $op = $stream->expect(Operator::$subscriptOperators);
                $paren = PairMatcher::parenOf($op);
                if (!$stream->match($paren)) {
                    $expr = $this->parse($stream);
                } else {
                    $expr = null;
                }
                $ret = new \Mystique\PHP\Node\Subscript($ret, $expr, new Operator($op));
                $stream->expect($paren);
            }
        }
        return $ret;
    }


    function parse(TokenStream $stream, $haveLvalue = false)
    {
        if ($stream->match(Operator::$unaryOperators)) {
            $op = $stream->current();
            $operator = new Operator($op);
            $stream->next();
            $rValue = $this->parse($stream);
            if ($rValue instanceof ExpressionAbstract) {
                $precedence = $this->determinePrecedence($rValue, $operator);

                switch ($precedence) {
                    case 'right':
                        $lValue = new UnaryExpression($operator, $rValue);
                        break;
                    case 'left':
                        $lValue = $rValue;
                        $lValue->setLeft(new UnaryExpression($operator, $lValue->getLeft()));
                        break;
                    default:
                        throw new \RuntimeException("Unexpected precedence $precedence");
                }
            } else {
                $lValue = new UnaryExpression($operator, $rValue);
            }
        } elseif ($stream->match('(')) {
            $stream->next();
            $lValue = new ParenthesizedExpression($this->parse($stream));
            $stream->expect(')');
        } else {
            $lValue = $this->parseValue($stream);
        }

        $lValue = $this->parseSubscript($stream, $lValue);

        // special case ? ... :
        if($stream->valid() && $stream->match(':')) {
            return $lValue;
        } elseif($stream->valid() && $stream->match('?')) {
            $operator = new Operator($stream->current());
            $stream->next();
            if($stream->match(':')) {
                $lCase = null;
            } else {
                $lCase = $this->parse($stream);
            }
            $stream->expect(':');
            $rCase = $this->parse($stream);
            return new TernaryExpression($lValue, $operator, $lCase, $rCase);
        } elseif ($stream->valid() && $stream->match(Operator::$binaryOperators)) {
            $op = $stream->current();
            $stream->next();
            $rValue = $this->parse($stream);
            $operator = new Operator($op);

            if ($rValue instanceof ExpressionAbstract) {
                $precedence = $this->determinePrecedence($rValue, $operator);
                switch ($precedence) {
                    case 'right':
                        $ret = new BinaryExpression($lValue, $operator, $rValue);
                        break;
                    case 'left':
                        $ret = $rValue;
                        $ret->setLeft(new BinaryExpression($lValue, $operator, $ret->getLeft()));
                        break;
                    default:
                        throw new \RuntimeException("Unexpected precedence $precedence");
                }
            } else {
                $ret = new BinaryExpression($lValue, new Operator($op), $rValue);
            }
        } else {
            $ret = $lValue;
        }
        return $ret;
    }

    public function determinePrecedence($right, $operator)
    {
        if ($right instanceof ParenthesizedExpression) {
            $precedence = 'right';
        } else {
            $precedence = Operator::precedence($operator, $right->getOperator());

            switch ($precedence) {
                case -1: // lvalue has precedence over rvalue
                    $precedence = 'left';
                    break;
                case 0:
                    if (Operator::getAssociativity($operator) == 'right') {
                        $precedence = 'right';
                    } else {
                        $precedence = 'left';
                    }
                    break;
                case 1:
                    $precedence = 'right';
                    break;
                default:
                    throw new UnexpectedValueException('Invalid precedence returned: ' . $precedence);
            }
        }
        return $precedence;
    }


    function parseNestedVariable(TokenStream $stream)
    {
        $value = new NestedVariable();
        if ($stream->match('{')) {
            $stream->next();
            $value->children->append($this->parse($stream));
            $stream->expect('}');
        } else {
            $value->children->append($this->parseValue($stream));
        }
        return $value;
    }

    
    function parseValue(TokenStream $stream)
    {
        $token = $stream->current();

        $value = null;

        if($stream->match(T_STRING, array('null', 'false', 'true', 'self'))) {
            switch ($stream->current()->value) {
                case 'null':
                    $value = new Value(null, Value::T_NULL);
                    $stream->next();
                    break;
                case 'false':
                case 'true':
                    $value = new Value($token->value == 'true', Value::T_BOOL);
                    $stream->next();
                    break;
                case 'self':
                    $value = new Name($token->value);
                    $stream->next();
                    break;
                default:
                    throw new UnexpectedValueException("?");
            }
        } elseif ($this->parsers['name']->match($stream)) {
            $value = $this->parseName($stream);
        } elseif ($token->match(T_FUNCTION)) {
            if (!isset($this->parsers['closure'])) {
                throw new \LogicException('No parent parser to subparse to, so closures can not be parsed');
            }
            $value = $this->parsers['closure']->parse($stream);
        } else {
            switch ($token->type) {
                case '$':
                    $stream->next();
                    $value = $this->parseNestedVariable($stream);
                    break;
                case '"':
                    $value = $this->parseString($stream);
                    break;
                case T_LNUMBER:
                    $value = new Value($token->value, Value::T_INTEGER);
                    $stream->next();
                    break;
                case T_DNUMBER:
                    $value = new Value($token->value, Value::T_FLOAT);
                    $stream->next();
                    break;
                case T_CONSTANT_ENCAPSED_STRING:
                    $value = new \Mystique\PHP\Node\ConstantString(substr($token->value, 1, -1), $token->value[0]);
                    $stream->next();
                    break;
                case T_NS_SEPARATOR:
                    $value = $this->parseName($stream);
                    break;
                case T_STATIC:
                    $value = new Name($token->value);
                    $stream->next();
                    break;
                case T_VARIABLE:
                    $value = new \Mystique\PHP\Node\Variable(substr($token->value, 1));
                    $stream->next();
                    break;
                default:
                    $stream->err(
                        array_merge(
                            NameParser::$functionLikeConstructs,
                            array(T_VARIABLE, T_STRING, T_CONSTANT_ENCAPSED_STRING, T_NUM_STRING, T_LNUMBER, T_DNUMBER, T_NS_SEPARATOR)
                        )
                    );
            }
        }
        return $value;
    }


    function parseString(TokenStream $stream)
    {
        $stream->next();
        $ret = new \Mystique\PHP\Node\StringNode();
        while (!$stream->match('"')) {
            if ($stream->match(T_ENCAPSED_AND_WHITESPACE)) {
                $ret->children->append(new Value($stream->current()->value, Value::T_STRING));
                $stream->next();
            } elseif ($stream->match(T_DOLLAR_OPEN_CURLY_BRACES)) {
                $stream->next();
                $var = $stream->expect(T_STRING_VARNAME);
                $ret->children->append(new \Mystique\PHP\Node\Variable($var->value));
                $stream->expect('}');
            } elseif ($stream->match(T_CURLY_OPEN)) {
                $stream->expect(T_CURLY_OPEN);
                $ret->children->append(new \Mystique\PHP\Node\Placeholder($this->parse($stream)));
                $stream->expect('}');
            } else {
                $ret->children->append($this->parse($stream));
            }
        }
        $stream->expect('"');
        return $ret;
    }


    function parseList(TokenStream $stream, $allowEmpty = false)
    {
        $argumentList = new \Mystique\PHP\Node\ExprList();

        if ($allowEmpty) {
            while (!$stream->match(')')) {
                if ($stream->match(',')) {
                    $argumentList->children->append(new \Mystique\PHP\Node\Noop());
                    $stream->next();
                    if ($stream->match(')')) {
                        $argumentList->children->append(new \Mystique\PHP\Node\Noop());
                    }
                } else {
                    $argumentList->children->append($this->parse($stream));
                    if (!$stream->match(')')) {
                        $stream->expect(',');
                        if ($stream->match(')')) {
                            $argumentList->children->append(new \Mystique\PHP\Node\Noop());
                        }
                        continue;
                    }
                }
            }
        } else {
            $first = true;
            do {
                if (!$first) {
                    $stream->next();
                } else {
                    $first = false;
                }
                $argumentList->children->append($this->parse($stream));
            } while ($stream->match(','));
        }
        return $argumentList;
    }


    function parseName(TokenStream $stream)
    {
        return $this->parsers['name']->parse($stream);
    }


    function match(TokenStream $stream)
    {
        throw new \LogicException("Unimplemented");
    }
}