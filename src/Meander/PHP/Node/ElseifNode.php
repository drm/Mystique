<?php

namespace Meander\PHP\Node;

class ElseifNode extends IfNode {
    function getNodeType()
    {
        return 'Elseif';
    }
}