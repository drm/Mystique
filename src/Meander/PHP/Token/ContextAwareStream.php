<?php

namespace Meander\PHP\Token;


class ContextAwareStream extends TokenStream {
    function getContext() {
        return $this->context;
    }
}