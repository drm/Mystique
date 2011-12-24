<?php
// TODO class is generic, not PHP specific
namespace Mystique\PHP\Node;

interface Visitor {
    function enterNode(Node $node);
    function exitNode(Node $node);
}