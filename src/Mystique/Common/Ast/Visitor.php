<?php
namespace Mystique\Common\Ast;

use Mystique\Common\Ast\Node\Node;

interface Visitor {
    function enterNode(Node $node);
    function exitNode(Node $node);
}