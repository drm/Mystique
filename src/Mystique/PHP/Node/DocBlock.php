<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;

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