<?php
// TODO class is generic, not PHP specific
namespace Meander\PHP\Node;

interface Visitor {
    function enterNode(Node $node);
    function exitNode(Node $node);
}