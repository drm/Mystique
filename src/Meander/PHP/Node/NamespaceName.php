<?php

namespace Meander\PHP\Node;

class NamespaceName extends Name {
    function getNodeType()
    {
        return 'Namespace';
    }
}