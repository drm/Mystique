<?php

namespace Mystique\Common\Ast\Node;

interface Branch extends Node {
    function getNodeChildren();
}