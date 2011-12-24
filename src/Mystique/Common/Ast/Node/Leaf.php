<?php

namespace Mystique\Common\Ast\Node;

interface Leaf extends Node {
    function getNodeValue();
}
