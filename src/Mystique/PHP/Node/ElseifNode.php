<?php

namespace Mystique\PHP\Node;

class ElseifNode extends IfNode {
    function getNodeType()
    {
        return 'Elseif';
    }
}