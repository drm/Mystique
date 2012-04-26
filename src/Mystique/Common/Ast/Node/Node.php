<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 * @license
 */

namespace Mystique\Common\Ast\Node;

/**
 * Base interface for a Node in the AST.
 */
interface Node {
    function getNodeType();
    function getNodeAttributes();
}