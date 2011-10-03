<?php

namespace Meander\PHP\Node;

class Html extends LeafAbstract {
    function __construct($data) {
        $this->html = $data;
    }

    function getNodeValue()
    {
        return $this->html;
    }


}