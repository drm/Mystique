<?php

namespace Mystique\Common\Ast\Node;

/**
 * 
 */
interface Node {
    function getNodeType();
    function getNodeAttributes();
}