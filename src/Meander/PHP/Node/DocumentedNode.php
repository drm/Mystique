<?php
namespace Meander\PHP\Node\DocumentedNode;

use \Meander\Compiler\CompilerInterface;
use \Meander\Compiler\Compilable;


class DocumentedNode implements Compilable {
    function __construct(DocBlock $docs, Compilable $node) {
        $this->docs = $docs;
        $this->node = $node;
    }

    function compile(CompilerInterface $compiler) {
        $compiler->compile($this->docs);
        $compiler->write("\n");
        $compiler->compile($this->node);
    }
}