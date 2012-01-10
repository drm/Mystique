<?php

namespace Mystique\Annotation\Node;

use Mystique\Common\Token\Token;


class Scalar extends \Mystique\Common\Ast\Node\LeafAbstract {
    function __construct(Token $token) {
        $this->token = $token;
    }

    function getNodeValue() {
        return $this->token->value;
    }

    function getNodeType()
    {
        return $this->token->type;
    }
}