<?php


namespace Mystique\Common;

interface Lang {
    function getParser();
    function getTokenizer();
    function getCompiler();
}