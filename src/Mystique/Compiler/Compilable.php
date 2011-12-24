<?php

namespace Mystique\Compiler;

interface Compilable
{
    function compile(CompilerInterface $compiler);
}