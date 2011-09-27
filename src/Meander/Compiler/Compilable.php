<?php

namespace Meander\Compiler;

interface Compilable
{
    function compile(CompilerInterface $compiler);
}