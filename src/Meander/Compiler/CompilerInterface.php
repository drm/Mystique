<?php
namespace Meander\Compiler;

interface CompilerInterface
{
    /**
     * @abstract
     * @param $code
     * @return CompilerInterface
     */
    function write($code);

    /**
     * @abstract
     * @param Compilable $node
     * @return CompilerInterface
     */
    function compile(Compilable $node);
}