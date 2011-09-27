<?php

namespace Meander\PHP\Node;

interface Branch extends Node {
    function getNodeChildren();
}