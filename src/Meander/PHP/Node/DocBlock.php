<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;

class DocBlock implements Compilable {
    function __construct($docs) {
        $this->docs = $docs;
    }

    function compile(CompilerInterface $compiler) {
        $compiler->write('/**')->write("\n");
        if($trimmed = trim($this->docs)) {
            foreach(explode("\n", $trimmed) as $line) {
                $compiler->write(' * ')->write($line)->write("\n");
            }
        }
        $compiler->write(' */');
    }
}