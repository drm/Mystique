<?php

namespace Meander\PHP\Parser;

use UnexpectedValueException;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\Type;
use \Meander\PHP\Token\Operator;

use \Meander\PHP\Node\Value;
use \Meander\PHP\Node\Name;
use \Meander\PHP\Node\NamespacedName;
use \Meander\PHP\Node\Call;


class ExpressionParser implements Parser
{
    protected $parsers = array();

    function __construct(ParserBase $parent = null)
    {
        if ($parent) {
            $this->parsers['closure'] = new ClosureParser($parent);
        }
    }


    function parseSubscript(TokenStream $stream, \Meander\PHP\Node\Node $expression)
    {
        $ret = $expression;

        while ($stream->valid() && $stream->match(Operator::$subscriptOperators)) {
            if ($stream->match('(')) {
                $stream->next();
                if (!$stream->match(')')) {
                    $arguments = $this->parseList($stream, $ret instanceof Name && in_array($ret, array('list', 'array')));
                } else {
                    $arguments = new \Meander\PHP\Node\ExprList();
                }
                $stream->expect(')');
                $ret = new Call($ret, $arguments);
            } elseif ($stream->match(array(T_DEC, T_INC))) {
                $ret = new \Meander\PHP\Node\PostUnaryExpression(new Operator($stream->current()), $ret);
                $stream->next();
            } else {
                $op = $stream->expect(Operator::$subscriptOperators);
                $paren = \Meander\PHP\Token\PairMatcher::parenOf($op);
                if (!$stream->match($paren)) {
                    $expr = $this->parse($stream);
                } else {
                    $expr = null;
                }
                $ret = new \Meander\PHP\Node\Subscript($ret, $expr, new Operator($op));
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
            if ($rValue instanceof \Meander\PHP\Node\ExpressionAbstract) {
                $precedence = $this->determinePrecedence($rValue, $operator);

                switch ($precedence) {
                    case 'right':
                        $lValue = new \Meander\PHP\Node\UnaryExpression($operator, $rValue);
                        break;
                    case 'left':
                        $lValue = $rValue;
                        $lValue->setLeft(new \Meander\PHP\Node\UnaryExpression($operator, $lValue->getLeft()));
                        break;
                    default:
                        throw new \RuntimeException("Unexpected precedence $precedence");
                }
            } else {
                $lValue = new \Meander\PHP\Node\UnaryExpression($operator, $rValue);
            }
        } elseif ($stream->match('(')) {
            $stream->next();
            $lValue = new \Meander\PHP\Node\ParenthesizedExpression($this->parse($stream));
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
            return new \Meander\PHP\Node\TernaryExpression($lValue, $operator, $lCase, $rCase);
        } elseif ($stream->valid() && $stream->match(Operator::$binaryOperators)) {
            $op = $stream->current();
            $stream->next();
            $rValue = $this->parse($stream);
            $operator = new Operator($op);

            if ($rValue instanceof \Meander\PHP\Node\ExpressionAbstract) {
                $precedence = $this->determinePrecedence($rValue, $operator);
                switch ($precedence) {
                    case 'right':
                        $ret = new \Meander\PHP\Node\BinaryExpression($lValue, $operator, $rValue);
                        break;
                    case 'left':
                        $ret = $rValue;
                        $ret->setLeft(new \Meander\PHP\Node\BinaryExpression($lValue, $operator, $ret->getLeft()));
                        break;
                    default:
                        throw new \RuntimeException("Unexpected precedence $precedence");
                }
            } else {
                $ret = new \Meander\PHP\Node\BinaryExpression($lValue, new Operator($op), $rValue);
            }
        } else {
            $ret = $lValue;
        }
        return $ret;
    }

    public function determinePrecedence($right, $operator)
    {
        if ($right instanceof \Meander\PHP\Node\ParenthesizedExpression) {
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
        $value = new \Meander\PHP\Node\NestedVariable();
        if ($stream->match('{')) {
            $stream->next();
            $value->children->append($this->parse($stream));
            $stream->expect('}');
        } else {
            $value->children->append($this->parseValue($stream));
        }
        return $value;
    }


    static $functionLikeConstructs = array(
        T_ARRAY,
        T_LIST,
        T_EMPTY,
        T_ISSET,
        T_DECLARE,
        T_UNSET,
        T_INCLUDE,
        T_EVAL
    );


    static $constants = array(
        T_FUNC_C, T_DIR, T_FILE, T_LINE, T_METHOD_C, T_CLASS_C
    );

    function parseValue(TokenStream $stream)
    {
        $token = $stream->current();

        $value = null;
        if ($token->match(self::$functionLikeConstructs) || $token->match(self::$constants)) {
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
                    $value = new \Meander\PHP\Node\ConstantString(substr($token->value, 1, -1), $token->value[0]);
                    $stream->next();
                    break;
                case T_NS_SEPARATOR:
                    $value = $this->parseName($stream);
                    break;
                case T_STATIC:
                    $value = new Name($token->value);
                    $stream->next();
                    break;
                case T_STRING:
                    switch ($token->value) {
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
                            $value = $this->parseName($stream);
                            break;
                    }
                    break;
                case T_VARIABLE:
                    $value = new \Meander\PHP\Node\Variable(substr($token->value, 1));
                    $stream->next();
                    break;
                default:
                    $stream->err(
                        array_merge(
                            self::$functionLikeConstructs,
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
        $ret = new \Meander\PHP\Node\StringNode();
        while (!$stream->match('"')) {
            if ($stream->match(T_ENCAPSED_AND_WHITESPACE)) {
                $ret->children->append(new Value($stream->current()->value, Value::T_STRING));
                $stream->next();
            } elseif ($stream->match(T_DOLLAR_OPEN_CURLY_BRACES)) {
                $stream->next();
                $var = $stream->expect(T_STRING_VARNAME);
                $ret->children->append(new \Meander\PHP\Node\Variable($var->value));
                $stream->expect('}');
            } elseif ($stream->match(T_CURLY_OPEN)) {
                $stream->expect(T_CURLY_OPEN);
                $ret->children->append(new \Meander\PHP\Node\Placeholder($this->parse($stream)));
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
        $argumentList = new \Meander\PHP\Node\ExprList();

        if ($allowEmpty) {
            while (!$stream->match(')')) {
                if ($stream->match(',')) {
                    $argumentList->children->append(new \Meander\PHP\Node\Noop());
                    $stream->next();
                    if ($stream->match(')')) {
                        $argumentList->children->append(new \Meander\PHP\Node\Noop());
                    }
                } else {
                    $argumentList->children->append($this->parse($stream));
                    if (!$stream->match(')')) {
                        $stream->expect(',');
                        if ($stream->match(')')) {
                            $argumentList->children->append(new \Meander\PHP\Node\Noop());
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
        $namespace = array();
        if ($stream->match(self::$functionLikeConstructs)) {
            $value = new Name($stream->expect(self::$functionLikeConstructs)->value);
        } elseif ($stream->match(array(T_FILE, T_DIR, T_LINE, T_CLASS_C, T_METHOD_C, T_FUNC_C))) {
            $value = new Name($stream->current()->value);
            $stream->next();
        } else {
            if ($stream->match(T_NS_SEPARATOR)) {
                $namespace[] = $stream->current()->value;
                $stream->next();
            }
            $namespace[] = $stream->expect(T_STRING)->value;
            while ($stream->valid() && $stream->match(array(T_NS_SEPARATOR))) {
                $namespace[] = $stream->current()->value;
                $stream->next();
                $namespace[] = $stream->expect(T_STRING)->value;
            }
            $name = array_pop($namespace);

            if (count($namespace)) {
                $value = new NamespacedName(join('', $namespace), $name);
            } else {
                $value = new Name($name);
            }
        }
        return $value;
    }


    function match(TokenStream $stream)
    {
        throw new \LogicException("Unimplemented");
    }
}